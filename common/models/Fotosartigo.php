<?php

namespace common\models;

/**
 * This is the model class for table "fotosartigos".
 *
 * @property int $id
 * @property int $idartigo
 * @property string $caminhofoto
 *
 * @property Artigo $idartigo0
 */
class Fotosartigo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fotosartigos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idartigo', 'caminhofoto'], 'required'],
            [['idartigo'], 'integer'],
            [['caminhofoto'], 'string', 'max' => 350],
            [['idartigo'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['idartigo' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idartigo' => 'Idartigo',
            'caminhofoto' => 'Caminhofoto',
        ];
    }

    /**
     * Gets query for [[Idartigo0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdartigo0()
    {
        return $this->hasOne(Artigo::class, ['id' => 'idartigo']);
    }
}
