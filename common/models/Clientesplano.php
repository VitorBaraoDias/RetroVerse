<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "clientesplanos".
 *
 * @property int $id
 * @property int $idplano
 * @property int $idperfil
 * @property string $expira
 *
 * @property Perfils $idperfil0
 * @property Planos $idplano0
 */
class Clientesplano extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientesplanos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idplano', 'idperfil', 'expira'], 'required'],
            [['idplano', 'idperfil'], 'integer'],
            [['expira'], 'safe'],
            [['idperfil'], 'exist', 'skipOnError' => true, 'targetClass' => Perfils::class, 'targetAttribute' => ['idperfil' => 'id']],
            [['idplano'], 'exist', 'skipOnError' => true, 'targetClass' => Planos::class, 'targetAttribute' => ['idplano' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idplano' => 'Idplano',
            'idperfil' => 'Idperfil',
            'expira' => 'Expira',
        ];
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

    /**
     * Gets query for [[Idplano0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlano()
    {
        return $this->hasOne(Plano::class, ['id' => 'idplano']);
    }
}
