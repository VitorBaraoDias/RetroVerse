<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metodosexpedicoes".
 *
 * @property int $id
 * @property string $nome
 *
 * @property Vendas[] $vendas
 */
class Metodosexpedicao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodosexpedicoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'],'string', 'max' => 150],
            [['nome'], 'unique'], // Garante que o nome seja único

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Vendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendas()
    {
        return $this->hasMany(Vendas::class, ['idmetodoexpedicao' => 'id']);
    }
}
