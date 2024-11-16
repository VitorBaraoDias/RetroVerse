<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ivas".
 *
 * @property int $id
 * @property float $percentagem
 * @property int $emvigor
 *
 * @property Planos[] $planos
 */
class Iva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ivas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['percentagem', 'emvigor'], 'required'],
            ['percentagem', 'number'],
            ['emvigor', 'boolean'],
            ['emvigor', 'validateUniqueActiveIva'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'percentagem' => 'Percentagem',
            'emvigor' => 'Active status',
        ];
    }

    /**
     * Gets query for [[Planos]].
     *
     * @return \yii\db\ActiveQuery
     */
    // Método de validação personalizada
    public function validateUniqueActiveIva($attribute, $params)
    {
        if ($this->emvigor) {
            $existingActiveIva = self::find()
                ->where(['emvigor' => 1])
                ->andWhere(['<>', 'id', $this->id ?? 0]) // Exclui o registro atual ao editar
                ->exists();

            if ($existingActiveIva) {
                $this->addError($attribute, 'Já existe um IVA ativo. Apenas um IVA pode estar ativo.');
            }
        }
    }
    public function getPlanos()
    {
        return $this->hasMany(Planos::class, ['idiva' => 'id']);
    }
}
