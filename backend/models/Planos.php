<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Planos".
 *
 * @property int $id
 * @property float $precomensal
 * @property int $idiva
 * @property string $descricao
 * @property int|null $ativo
 */
class Planos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Planos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['precomensal', 'idiva', 'descricao'], 'required'],
            [['precomensal'], 'number'],
            [['idiva', 'ativo'], 'integer'],
            [['descricao'], 'string', 'max' => 100],
            [['idiva'], 'exist', 'skipOnError' => true, 'targetClass' => Ivas::class, 'targetAttribute' => ['idiva' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'precomensal' => 'Precomensal',
            'idiva' => 'Idiva',
            'descricao' => 'Descricao',
            'ativo' => 'Ativo',
        ];
    }
}
