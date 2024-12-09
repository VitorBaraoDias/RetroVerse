<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "favoritos".
 *
 * @property int $id
 * @property int $idartigo
 * @property int $idperfil
 *
 * @property Artigos $idartigo0
 * @property Perfils $idperfil0
 */
class Favorito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favoritos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idartigo', 'idperfil'], 'required'],
            [['idartigo', 'idperfil'], 'integer'],
            [['idartigo'], 'exist', 'skipOnError' => true, 'targetClass' => Artigos::class, 'targetAttribute' => ['idartigo' => 'id']],
            [['idperfil'], 'exist', 'skipOnError' => true, 'targetClass' => Perfils::class, 'targetAttribute' => ['idperfil' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idartigo' => 'Idartigo',
            'idperfil' => 'Idperfil',
        ];
    }

    /**
     * Gets query for [[Idartigo0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdartigo0()
    {
        return $this->hasOne(Artigos::class, ['id' => 'idartigo']);
    }

    /**
     * Gets query for [[Idperfil0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdperfil0()
    {
        return $this->hasOne(Perfils::class, ['id' => 'idperfil']);
    }
}
