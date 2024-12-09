<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tamanhos".
 *
 * @property int $id
 * @property string $tamanho
 *
 * @property Artigos[] $artigos
 */
class Tamanho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tamanhos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tamanho'], 'required'],
            [['tamanho'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tamanho' => 'Tamanho',
        ];
    }

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
            return $this->hasMany(Artigo::class, ['idtamanho' => 'id']);
    }
}
