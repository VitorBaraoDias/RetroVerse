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
        return $this->hasOne(Mensagenstexto::class, ['id' => 'idmensagem']);
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
//Obter dados do registo em causa
        if($insert){

            $myObj=new \stdClass();
            if($this->mensagem){
                $myObj->descricao= $this->mensagem->descricao;
                $myJSON = json_encode($myObj);
                $topic = "chat/{$this->idchat}";

                $this->FazPublishNoMosquitto($topic,$myJSON);
            }
            else if($this->mensagemfoto){
                var_dump($this->mensagemfoto);
                die();
            }

        }
    }
    public function FazPublishNoMosquitto($canal,$msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = "vitor"; // set your username
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
