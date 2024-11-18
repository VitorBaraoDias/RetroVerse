<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comissoes".
 *
 * @property int $id
 * @property float $comissao
 *
 * @property Artigos[] $artigos
 */
class Comissao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comissoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comissao'], 'required'],
            [['comissao'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comissao' => 'Comissao',
        ];
    }

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasMany(Artigos::class, ['idcomissao' => 'id']);
    }
}
