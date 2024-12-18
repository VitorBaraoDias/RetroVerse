<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comissoes".
 *
 * @property int $id
 * @property float $comissao
 * @property int $ativo
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
            [['comissao', 'ativo'], 'required'],
            [['comissao'], 'number'],
            [['ativo'], 'boolean'],
            ['ativo', 'validateUniqueActiveComissao'],

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
            'ativo' => 'Ativo',
        ];
    }

    public function validateUniqueActiveComissao($attribute, $params)
    {
        if ($this->ativo) {
            $existingActiveComissao = self::find()
                ->where(['ativo' => 1])
                ->andWhere(['<>', 'id', $this->id ?? 0]) // Exclui o registro atual ao editar
                ->exists();

            if ($existingActiveComissao) {
                $this->addError($attribute, 'Já existe uma comissoa ativo. Apenas uma Comissão pode estar ativa.');
            }
        }
    }
    public static function getIdActiveComissao()
    {
        return self::find()
            ->select('id')
            ->where(['ativo' => 1])
            ->scalar(); // Retorna o valor diretamente como um inteiro ou null
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
