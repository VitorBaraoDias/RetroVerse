<?php

namespace common\models;

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
}
