<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "denuncias".
 *
 * @property int $id
 * @property int $iddenunciante
 * @property int $iddenunciado
 * @property int $idartigo
 * @property string $descricao
 *
 * @property Artigos $idartigo0
 * @property Perfils $iddenunciado0
 * @property Perfils $iddenunciante0
 */
class Denuncia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'denuncias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iddenunciante', 'iddenunciado', 'idartigo', 'descricao'], 'required'],
            [['id', 'iddenunciante', 'iddenunciado', 'idartigo'], 'integer'],
            [['descricao'], 'string', 'max' => 150],
            [['idartigo'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['idartigo' => 'id']],
            [['iddenunciado'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['iddenunciado' => 'id']],
            [['iddenunciante'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['iddenunciante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iddenunciante' => 'Iddenunciante',
            'iddenunciado' => 'Iddenunciado',
            'idartigo' => 'Idartigo',
            'descricao' => 'Describe',
        ];
    }

    /**
     * Gets query for [[Idartigo0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdartigo0()
    {
        return $this->hasOne(Artigo::class, ['id' => 'idartigo']);
    }

    /**
     * Gets query for [[Iddenunciado0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIddenunciado0()
    {
        return $this->hasOne(Perfil::class, ['id' => 'iddenunciado']);
    }

    /**
     * Gets query for [[Iddenunciante0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIddenunciante0()
    {
        return $this->hasOne(Perfil::class, ['id' => 'iddenunciante']);
    }
    public static function hasAlreadyReported($userId, $articleId)
    {
        return self::find()
            ->where(['iddenunciante' => $userId, 'idartigo' => $articleId])
            ->exists();
    }
}
