<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhascarrinhos".
 *
 * @property int $id
 * @property int $idcarrinho
 * @property int $idartigo
 *
 * @property Artigos $idartigo0
 * @property Carrinhos $idcarrinho0
 */
class Linhascarrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhascarrinhos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idcarrinho', 'idartigo'], 'required'],
            [['idcarrinho', 'idartigo'], 'integer'],
            [['idartigo'], 'exist', 'skipOnError' => true, 'targetClass' => Artigos::class, 'targetAttribute' => ['idartigo' => 'id']],
            [['idcarrinho'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinhos::class, 'targetAttribute' => ['idcarrinho' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idcarrinho' => 'Idcarrinho',
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
     * Gets query for [[Idcarrinho0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinho::class, ['id' => 'idcarrinho']);
    }
}
