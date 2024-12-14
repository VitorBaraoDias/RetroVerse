<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "estadoencomendas".
 *
 * @property int $id
 * @property string $descricao
 * @property int $status
 *
 * @property Vendas[] $vendas
 */
class Estadoencomenda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estadoencomendas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'status'], 'required'],
            [['status'], 'integer'],
            [['descricao'], 'string', 'max' => 150],
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
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Vendas]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getVendas()
    {
        return $this->hasMany(Vendas::class, ['idestadoencomenda' => 'id']);
    }

    public static function getIdByStatusCode1()
    {
        $record = self::find()->where(['status' => 1])->one();
        return $record ? $record->id : null;
    }
    public function isFinalState()
    {
        $finalState = self::find()->orderBy(['status' => SORT_DESC])->one();

        return $this->status === $finalState->status;
    }
}
