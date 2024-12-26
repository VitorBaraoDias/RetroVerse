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
 * @property Artigo $idartigo0
 * @property Perfil $idperfil0
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
            [['idartigo'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['idartigo' => 'id']],
            [['idperfil'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idperfil' => 'id']],
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
     * @return bool|int|string|\yii\db\ActiveQuery
     */
    public static function getFavoritosCount($idPerfil)
    {
        return self::find()
            ->where(['idperfil' => $idPerfil]) // Filtra pelo ID do perfil
            ->count(); // Conta o número de registros
    }
    public function getArtigo()
    {
        return $this->hasOne(Artigo::class, ['id' => 'idartigo']);
    }

    /**
     * Gets query for [[Idperfil0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'idperfil']);
    }

    public static function isFavorito($userId, $artigoId)
    {
        return self::find()
            ->where(['idperfil' => $userId, 'idartigo' => $artigoId])
            ->exists();
    }

}
