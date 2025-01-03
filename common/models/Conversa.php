<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "conversas".
 *
 * @property int $id
 * @property int $idchat
 * @property int $iduser
 * @property int $idmensagem
 * @property string $tipo
 *
 * @property Listachats $idchat0
 * @property Mensagenstextos $idmensagem0
 * @property Mensagemfotos $idmensagem1
 */
class Conversa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conversas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iduser', 'idchat', 'idmensagem', 'tipo'], 'required'],
            [['iduser', 'idchat', 'idmensagem'], 'integer'],
            [['tipo'], 'string', 'max' => 150],
            [['idchat'], 'exist', 'skipOnError' => true, 'targetClass' => Listachats::class, 'targetAttribute' => ['idchat' => 'id']],
            [['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['iduser' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idchat' => 'Idchat',
            'idmensagem' => 'Idmensagem',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * Gets query for [[Idchat0]].
     *
     * @return array|\yii\db\ActiveQuery|\yii\db\ActiveRecord[]
     */

    public static function findByChatId($idchat)
    {
        return self::find()->where(['idchat' => $idchat])->all();
    }
    public function getChat()
    {
        return $this->hasOne(Listachats::class, ['id' => 'idchat']);
    }
    /**
     * Gets query for [[Idmensagem0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensagem()
    {
        if ($this->tipo === 'TEXTO') {
            return $this->hasOne(Mensagemtexto::class, ['id' => 'idmensagem']);
        } elseif ($this->tipo === 'PROPOSTA') {
            return $this->hasOne(Mensagemproposta::class, ['id' => 'idmensagem']);
        } elseif ($this->tipo === 'FOTO') {
            return $this->hasOne(Mensagemfoto::class, ['id' => 'idmensagem']);
        }
        return null; // Caso o tipo não seja reconhecido
    }


    /**
     * Gets query for [[Idmensagem1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensagemfoto()
    {
        return $this->hasOne(Mensagemfoto::class, ['id' => 'idmensagem']);
    }
    public function getMensagemproposta()
    {
        return $this->hasOne(Mensagemproposta::class, ['id' => 'idmensagem']);
    }
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $myObj = new \stdClass();
            $myObj->iduser = $this->iduser;
            $myObj->idchat = $this->idchat;

            // Verifica o tipo de mensagem e obtém os dados correspondentes
            if ($this->tipo === 'TEXTO' && $this->mensagem) {
                $myObj->tipo = 'TEXTO';
                $myObj->descricao = $this->mensagem->descricao;
            } elseif ($this->tipo === 'PROPOSTA' && $this->mensagemproposta) {
                $myObj->id = $this->id;
                $myObj->tipo = 'PROPOSTA';
                $myObj->idProposta = $this->mensagemproposta->id;
                $myObj->preco = $this->mensagemproposta->preco;
                $myObj->estado = $this->mensagemproposta->estado;
                $myObj->idartigo = $this->mensagemproposta->idartigo;
                $myObj->artigoPreco = $this->mensagemproposta->artigo->precoanuncio;
            } elseif ($this->tipo === 'FOTO' && $this->mensagemfoto) {
                $myObj->tipo = 'FOTO';
                $myObj->url = $this->mensagemfoto->url;
                $myObj->legenda = $this->mensagemfoto->legenda;
            } else {
                Yii::error("Tipo de mensagem não reconhecido ou dados ausentes. Tipo: {$this->tipo}", __METHOD__);
                return;
            }

            // Publica no MQTT
            $myJSON = json_encode($myObj);
            $topic = "chat/{$this->idchat}";

            $this->FazPublishNoMosquitto($topic, $myJSON);
        }
    }
    public function FazPublishNoMosquitto($canal,$msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = Yii::$app->user->identity->username; // set your username
        $password = ""; // set your password
        $client_id = Yii::$app->user->identity ? Yii::$app->user->identity->id : 'guest'; // unique!
        $mqtt = new \Bluerhinos\phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password))
        {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        }
        else { file_put_contents("debug.output","Time out!"); }
    }
}
