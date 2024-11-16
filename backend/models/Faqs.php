<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "faqs".
 *
 * @property int $id
 * @property string $questao
 * @property string $resposta
 * @property string $categoria
 */
class Faqs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faqs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['questao', 'resposta', 'categoria'], 'required'],
            [['questao', 'resposta'], 'string', 'max' => 250],
            [['categoria'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'questao' => 'Questao',
            'resposta' => 'Resposta',
            'categoria' => 'Categoria',
        ];
    }
}
