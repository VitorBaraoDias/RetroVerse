<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mensagempropostas".
 *
 * @property int $id
 * @property float $preço
 * @property int $estado
 * @property int $idchat
 *
 * @property Chats $idchat0
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
            [['preço', 'estado', 'idchat'], 'required'],
            [['preço'], 'number'],
            [['estado', 'idchat'], 'integer'],
            [['idchat'], 'exist', 'skipOnError' => true, 'targetClass' => Chats::class, 'targetAttribute' => ['idchat' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preço' => 'Preço',
            'estado' => 'Estado',
            'idchat' => 'Idchat',
        ];
    }

    /**
     * Gets query for [[Idchat0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdchat0()
    {
        return $this->hasOne(Chats::class, ['id' => 'idchat']);
    }
}
