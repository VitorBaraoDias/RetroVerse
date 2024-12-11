<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vendas".
 *
 * @property int $id
 * @property int $idcomprador
 * @property int $idmetodoexpedicao
 * @property int $idtipopagamento
 * @property float $total
 * @property string $nome
 * @property string $datavenda
 * @property int|null $estadoencomenda
 * @property string $codigopostal
 * @property string $morada
 * @property string $pais
 * @property string $cidade
 * @property string $codigo
 * @property Avaliacoes[] $avaliacoes
 * @property Devolucoes[] $devolucoes
 * @property Perfils $idcomprador0
 * @property Metodosexpedicoes $idmetodoexpedicao0
 * @property Tipopagamento $idtipopagamento0
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
            [['idcomprador', 'idmetodoexpedicao', 'idtipopagamento', 'nome', 'codigopostal', 'morada', 'pais', 'cidade', 'total'], 'required'],
            [['idcomprador', 'idmetodoexpedicao', 'idtipopagamento', 'datavenda', 'estadoencomenda'], 'integer'],
            [['total'], 'number'],
            [['datavenda'], 'safe'],
            [['nome'], 'string', 'max' => 150],
            [['codigopostal'], 'string', 'max' => 10],
            [['morada'], 'string', 'max' => 350],
            [['pais', 'cidade'], 'string', 'max' => 100],
            [['codigo'], 'string', 'max' => 255],
            [['idcomprador'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idcomprador' => 'id']],
            [['idtipopagamento'], 'exist', 'skipOnError' => true, 'targetClass' => Tipopagamento::class, 'targetAttribute' => ['idtipopagamento' => 'id']],
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
            'idtipopagamento' => 'Idtipopagamento',
            'total' => 'Total',
            'nome' => 'Nome',
            'datavenda' => 'Datavenda',
            'estadoencomenda' => 'Estadoencomenda',
            'codigopostal' => 'Codigopostal',
            'morada' => 'Morada',
            'pais' => 'Pais',
            'cidade' => 'Cidade',
            'codigo' => 'Codigo',

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
     * Gets query for [[Idmetodoexpedicao0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdmetodoexpedicao0()
    {
        return $this->hasOne(Metodosexpedicoes::class, ['id' => 'idmetodoexpedicao']);
    }

    /**
     * Gets query for [[Idtipopagamento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdtipopagamento0()
    {
        return $this->hasOne(Tipopagamento::class, ['id' => 'idtipopagamento']);
    }

    /**
     * Gets query for [[Linhavendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhavendas()
    {
        return $this->hasMany(Linhavenda::class, ['idvenda' => 'id']);
    }

    public function getIdartigo0()
    {
        return $this->hasOne(Artigo::class, ['id' => 'idartigo']);
    }
    public function beforeSave($insert)
    {
        if ($insert) {
            // Gera o código automaticamente apenas ao criar o registo
            $this->codigo = $this->gerarCodigoUnico();
        }
        return parent::beforeSave($insert);
    }

    private function gerarCodigoUnico()
    {
        // Gera um código único baseado no timestamp (apenas números)
        return str_pad(mt_rand(1, 999999999), 10, '0', STR_PAD_LEFT);
    }
}

