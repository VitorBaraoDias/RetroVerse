<?php

namespace common\models;

use app\models\Perfils;
use Yii;

/**
 * This is the model class for table "seguidores".
 *
 * @property int $id
 * @property int $idperfil
 * @property int $idseguidor
 *
 * @property Perfils $idperfil0
 * @property Perfils $idseguidor0
 */
class Seguidor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguidores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idperfil', 'idseguidor'], 'required'],
            [['idperfil', 'idseguidor'], 'integer'],
            [['idperfil'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idperfil' => 'id']],
            [['idseguidor'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idseguidor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idperfil' => 'Idperfil',
            'idseguidor' => 'Idseguidor',
        ];
    }

    /**
     * Gets query for [[Idperfil0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdperfil0()
    {
        return $this->hasOne(Perfil::class, ['id' => 'idperfil']);
    }

    /**
     * Gets query for [[Idseguidor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdseguidor0()
    {
        return $this->hasOne(Perfil::class, ['id' => 'idseguidor']);
    }
}
