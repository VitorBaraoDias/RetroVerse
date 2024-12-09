<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tipopagamento".
 *
 * @property int $id
 * @property string $descricao
 *
 * @property Vendas $id0
 * @property Vendas[] $vendas
 */
class Tipopagamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipopagamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'descricao'], 'required'],
            [['id'], 'integer'],
            [['descricao'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Venda::class, 'targetAttribute' => ['id' => 'id']],
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
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Venda::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[Vendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendas()
    {
        return $this->hasMany(Venda::class, ['idtipopagamento' => 'id']);
    }
}
