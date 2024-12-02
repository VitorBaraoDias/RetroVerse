<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vendas".
 *
 * @property int $id
 * @property int $idcomprador
 * @property int $idmetodoexpedicao
 * @property int $idmetodopagamento
 * @property float $total
 * @property int $datavenda
 * @property int $idestadoencomenda
 *
 * @property Avaliacoes[] $avaliacoes
 * @property Devolucoes[] $devolucoes
 * @property Perfils $idcomprador0
 * @property Estadoencomendas $idestadoencomenda0
 * @property Metodosexpedicoes $idmetodoexpedicao0
 * @property Metodopagamentos $idmetodopagamento0
 * @property Linhavendas[] $linhavendas
 */
class Venda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idcomprador', 'idmetodoexpedicao', 'idmetodopagamento', 'total', 'datavenda', 'idestadoencomenda'], 'required'],
            [['idcomprador', 'idmetodoexpedicao', 'idmetodopagamento', 'datavenda', 'idestadoencomenda'], 'integer'],
            [['total'], 'number'],
            [['idcomprador'], 'exist', 'skipOnError' => true, 'targetClass' => Perfils::class, 'targetAttribute' => ['idcomprador' => 'id']],
            [['idestadoencomenda'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoencomendas::class, 'targetAttribute' => ['idestadoencomenda' => 'id']],
            [['idmetodoexpedicao'], 'exist', 'skipOnError' => true, 'targetClass' => Metodosexpedicoes::class, 'targetAttribute' => ['idmetodoexpedicao' => 'id']],
            [['idmetodopagamento'], 'exist', 'skipOnError' => true, 'targetClass' => Metodopagamentos::class, 'targetAttribute' => ['idmetodopagamento' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idcomprador' => 'Idcomprador',
            'idmetodoexpedicao' => 'Idmetodoexpedicao',
            'idmetodopagamento' => 'Idmetodopagamento',
            'total' => 'Total',
            'datavenda' => 'Datavenda',
            'idestadoencomenda' => 'Idestadoencomenda',
        ];
    }

    /**
     * Gets query for [[Avaliacoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacoes()
    {
        return $this->hasMany(Avaliacoes::class, ['idvenda' => 'id']);
    }

    /**
     * Gets query for [[Devolucoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevolucoes()
    {
        return $this->hasMany(Devolucoes::class, ['idvenda' => 'id']);
    }

    /**
     * Gets query for [[Idcomprador0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdcomprador0()
    {
        return $this->hasOne(Perfils::class, ['id' => 'idcomprador']);
    }

    /**
     * Gets query for [[Idestadoencomenda0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdestadoencomenda0()
    {
        return $this->hasOne(Estadoencomendas::class, ['id' => 'idestadoencomenda']);
    }

    /**
     * Gets query for [[Idmetodoexpedicao0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdmetodoexpedicao0()
    {
        return $this->hasOne(Metodosexpedicoes::class, ['id' => 'idmetodoexpedicao']);
    }

    /**
     * Gets query for [[Idmetodopagamento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdmetodopagamento0()
    {
        return $this->hasOne(Metodopagamentos::class, ['id' => 'idmetodopagamento']);
    }

    /**
     * Gets query for [[Linhavendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhavendas()
    {
        return $this->hasMany(Linhavendas::class, ['idvenda' => 'id']);
    }
}
