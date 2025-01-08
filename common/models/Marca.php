<?php

namespace common\models;
use Symfony\Component\Mime\Encoder\QpContentEncoder;

/**
 * This is the model class for table "marcas".
 *
 * @property int $id
 * @property string $nome
 *
 */
class Marca extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marcas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'ativo'], 'required'],
            [['nome'], 'string', 'max' => 150],
            [['ativo'], 'boolean'],
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
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
            return $this->hasMany(Artigo::class, ['idmarca' => 'id']);
    }
}
