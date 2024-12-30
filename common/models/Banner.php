<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descricao
 * @property string $caminhoimagem
 * @property string $link
 * @property int $ativo
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'descricao', 'caminhoimagem', 'link', 'ativo'], 'required'],
            [['ativo'], 'integer'],
            [['titulo', 'descricao', 'caminhoimagem', 'link'], 'string', 'max' => 250],
            [['textobotao'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'caminhoimagem' => 'Caminhoimagem',
            'link' => 'Link',
            'ativo' => 'Ativo',
            'textobotao' => 'Texto do Botão',
        ];
    }
}
