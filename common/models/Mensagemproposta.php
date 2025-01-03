<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mensagempropostas".
 *
 * @property int $id
 * @property float $preco
 * @property int $estado
 * @property int $iduser
 * @property int $idartigo
 * @property int $idchat
 *
 * @property Artigos $idartigo0
 * @property Perfils $iduser0
 */
class Mensagemproposta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensagempropostas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preco', 'estado', 'iduser', 'idartigo', 'idchat'], 'required'],
            [['preco'], 'number'],
            ['estado', 'in', 'range' => [0, 1, 2]], // 0 = Pendente, 1 = Recusado, 2 = Aceite
            [['estado', 'iduser', 'idartigo', 'idchat'], 'integer'],
            [['idartigo'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['idartigo' => 'id']],
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
            'preco' => 'preco',
            'estado' => 'Estado',
            'iduser' => 'Iduser',
            'idartigo' => 'Idartigo',
        ];
    }

    /**
     * Gets query for [[Idartigo0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigo()
    {
        return $this->hasOne(Artigo::class, ['id' => 'idartigo']);
    }

    /**
     * Gets query for [[Iduser0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIduser0()
    {
        return $this->hasOne(Perfils::class, ['id' => 'iduser']);
    }
    /**
     * Gets query for [[Idchat0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Listachats::class, ['id' => 'idchat']);
    }
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!$insert) {
            $myObj = new \stdClass();
            $myObj->iduser = $this->iduser;
            $myObj->idchat = $this->idchat;
            $myObj->tipo = 'PROPOSTA';
            $myObj->idProposta = $this->id;
            $myObj->preco = $this->preco;
            $myObj->estado = $this->estado;
            $myObj->idartigo = $this->idartigo;
            $myObj->artigoPreco = $this->artigo->precoanuncio;

            //buscar o id da mensagem que esta relacionado na tabela conversa
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
