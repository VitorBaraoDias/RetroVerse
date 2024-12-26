<?php

namespace common\models;

use common\models\Artigo;
use common\models\Mensagemfoto;
use common\models\Mensagemproposta;
use common\models\Mensagenstextos;
use common\models\Perfil;
//use common\models\;

/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property int $idremetente
 * @property int $iddestinatario
 * @property int $idartigo
 * @property int $idtipomensagem
 *
 * @property Artigo $idartigo0
 * @property \common\models\Perfil $iddestinatario0
 * @property Perfil $idremetente0
 * @property Tipomensagem $idtipomensagem0
 * @property \common\models\Mensagemfoto[] $mensagemfotos
 * @property \common\models\Mensagemproposta[] $mensagempropostas
 * @property Mensagenstexto[] $mensagenstextos
 */
class Listachats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listachats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idremetente', 'iddestinatario', 'idartigo'], 'required'],
            [['idremetente', 'iddestinatario', 'idartigo'], 'integer'],
            [['idartigo'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['idartigo' => 'id']],
            [['iddestinatario'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['iddestinatario' => 'id']],
            [['idremetente'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idremetente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idremetente' => 'Idremetente',
            'iddestinatario' => 'Iddestinatario',
            'idartigo' => 'Idartigo',
        ];
    }

    /**
     * Gets query for [[Idartigo0]].
     *
     * @return \common\models\Perfil
     */

    public function getDestinatarioOuRemetente()
    {
        if (\Yii::$app->user->identity) {
            $loggedInUserId = \Yii::$app->user->identity->id;

            // Se o usuário logado for o remetente, retorna o destinatário
            if ($loggedInUserId === $this->idremetente) {
                return $this->destinatario;
            }

            // Caso contrário, retorna o remetente
            if ($loggedInUserId === $this->iddestinatario) {
                return $this->idremetente0;
            }
        }

        // Retorna null se o usuário não estiver logado ou nenhuma condição for atendida
        return null;
    }
    public function getArtigo()
    {
        return $this->hasOne(Artigo::class, ['id' => 'idartigo']);
    }
    //criar funcao que retorna se o idremetente é o user logado, se for retornar o iddestinatario para usar.

    /**
     * Gets query for [[Iddestinatario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinatario()
    {
        return $this->hasOne(\common\models\Perfil::class, ['id' => 'iddestinatario']);
    }

    /**
     * Gets query for [[Idremetente0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdremetente0()
    {
        return $this->hasOne(\common\models\Perfil::class, ['id' => 'idremetente']);
    }

    /**
     * Gets query for [[Idtipomensagem0]].
     *
     * @return \yii\db\ActiveQuery
     */

    /**
     * Gets query for [[Mensagemfotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensagemfotos()
    {
        return $this->hasMany(Mensagemfotos::class, ['id_chat' => 'id']);
    }

    /**
     * Gets query for [[Mensagempropostas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensagempropostas()
    {
        return $this->hasMany(Mensagempropostas::class, ['idchat' => 'id']);
    }

    /**
     * Gets query for [[Mensagenstextos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMensagenstextos()
    {
        return $this->hasMany(Mensagenstexto::class, ['idchat' => 'id']);
    }
}
