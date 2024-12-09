<?php

namespace common\models;

use app\models\ArtigosPremium;
use app\models\Clientesplanos;
use common\models\Iva;

/**
 * This is the model class for table "planos".
 *
 * @property int $id
 * @property float $precomensal
 * @property int $idiva
 * @property string $descricao
 *
 * @property ArtigosPremium[] $artigosPremia
 * @property Clientesplanos[] $clientesplanos
 * @property Iva $idiva0
 */
class Plano extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'planos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['precomensal', 'idiva', 'descricao'], 'required'],
            [['precomensal'], 'number'],
            [['idiva'], 'integer'],
            [['descricao'], 'string', 'max' => 100],
            [['ativo'], 'boolean'],
            [['idiva'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::class, 'targetAttribute' => ['idiva' => 'id']],
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
            'ativo' => 'Active Status'
        ];
    }

    /**
     * Gets query for [[ArtigosPremia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigosPremia()
    {
        return $this->hasMany(ArtigosPremium::class, ['idPlano' => 'id']);
    }

    /**
     * Gets query for [[Clientesplanos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientesplanos()
    {
        return $this->hasMany(Clientesplanos::class, ['idplano' => 'id']);
    }

    /**
     * Gets query for [[Idiva0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIva()
    {
        return $this->hasOne(Iva::class, ['id' => 'idiva']);
    }
}
