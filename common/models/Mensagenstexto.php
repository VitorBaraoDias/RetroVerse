<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mensagenstextos".
 *
 * @property int $id
 * @property int $descricao
 * @property int $idchat
 *
 * @property Chats $idchat0
 */
class Mensagenstexto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensagenstextos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descricao',
        ];
    }

    /**
     * Gets query for [[Idchat0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdchat0()
    {
        return $this->hasOne(Conversa::class, ['id' => 'idchat']);
    }
}
