<?php

namespace common\models;

/**
 * This is the model class for table "artigospremium".
 *
 * @property int $id
 * @property int $idPlano
 *
 */
class Artigospremium extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artigospremium';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPlano'], 'required'],
            [['idPlano'], 'integer'],
            [['idPlano'], 'exist', 'skipOnError' => true, 'targetClass' => Plano::class, 'targetAttribute' => ['idPlano' => 'id']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idPlano' => 'Id Plano',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigo()
    {
        return $this->hasOne(Artigo::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[IdPlano0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlano()
    {
        return $this->hasOne(Plano::class, ['id' => 'idPlano']);
    }
}
