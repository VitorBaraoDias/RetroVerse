<?php

namespace common\models;

/**
 * This is the model class for table "mensagemfotos".
 *
 * @property int $id
 * @property int $id_chat
 * @property string $caminhofoto
 *
 * @property Chats $chat
 */
class Mensagemfoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensagemfotos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_chat', 'caminhofoto'], 'required'],
            [['id_chat'], 'integer'],
            [['caminhofoto'], 'string', 'max' => 200],
            [['id_chat'], 'exist', 'skipOnError' => true, 'targetClass' => Chats::class, 'targetAttribute' => ['id_chat' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_chat' => 'Id Chat',
            'caminhofoto' => 'Caminhofoto',
        ];
    }

    /**
     * Gets query for [[Chat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chats::class, ['id' => 'id_chat']);
    }
}
