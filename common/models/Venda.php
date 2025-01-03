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
 * @property string $datavenda
 * @property int $idestadoencomenda
 * @property string $nome
 * @property string $codigopostal
 * @property string $morada
 * @property string $pais
 * @property string $cidade
 * @property string $codigo
 * @property Avaliacoes[] $avaliacoes
 * @property Devolucoes[] $devolucoes
 * @property Perfils $idcomprador0
 * @property Estadoencomendas $idestadoencomenda0
 * @property Metodosexpedicoes $idmetodoexpedicao0
 * @property Tipopagamentos $idtipopagamento0
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
            [['idcomprador', 'idmetodoexpedicao', 'idtipopagamento', 'total', 'idestadoencomenda', 'nome', 'codigopostal', 'morada', 'pais', 'cidade'], 'required'],
            [['idcomprador', 'idmetodoexpedicao', 'idtipopagamento', 'idestadoencomenda'], 'integer'],
            [['total'], 'number'],
            [['datavenda'], 'safe'],
            [['nome'], 'string', 'max' => 150],
            [['codigopostal'], 'string', 'max' => 10],
            [['codigopostal'], 'match', 'pattern' => '/^\d{4}-\d{3}$/', 'message' => 'The postcode must be in the format 1234-567.'],
            [['morada'], 'string', 'max' => 350],
            [['pais', 'cidade'], 'string', 'max' => 100],
            [['codigo'], 'string', 'max' => 255],
            [['idcomprador'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['idcomprador' => 'id']],
            [['idmetodoexpedicao'], 'exist', 'skipOnError' => true, 'targetClass' => Metodosexpedicao::class, 'targetAttribute' => ['idmetodoexpedicao' => 'id']],
            [['idtipopagamento'], 'exist', 'skipOnError' => true, 'targetClass' => Tipopagamento::class, 'targetAttribute' => ['idtipopagamento' => 'id']],
            [['idestadoencomenda'], 'exist', 'skipOnError' => true, 'targetClass' => Estadoencomenda::class, 'targetAttribute' => ['idestadoencomenda' => 'id']],
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
            'datavenda' => 'Datavenda',
            'idestadoencomenda' => 'Idestadoencomenda',
            'nome' => 'Nome',
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
    public function getComprador()
    {
        return $this->hasOne(Perfil::class, ['id' => 'idcomprador']);
    }
    /**
     * Gets query for [[Idestadoencomenda0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoEncomenda()
    {
        return $this->hasOne(Estadoencomenda::class, ['id' => 'idestadoencomenda']);
    }

    /**
     * Gets query for [[Idmetodoexpedicao0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodoExpedicao()
    {
        return $this->hasOne(Metodosexpedicao::class, ['id' => 'idmetodoexpedicao']);
    }
    /**
     * Gets query for [[Idtipopagamento0]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getTipoPagamento()
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

    public function checkAndSetNextState()
    {
        $estadoAtual = $this->estadoEncomenda;

        $estadoFinal = Estadoencomenda::find()->orderBy(['status' => SORT_DESC])->one();

        if ($estadoAtual->status === $estadoFinal->status) {
            return;
        }

        foreach ($this->linhavendas as $linhaVenda) {

            if ($linhaVenda->idestadoencomenda0->status !== $estadoFinal->status) {
                return;
            }
        }


        $this->idestadoencomenda = $estadoFinal->id;
        $this->save(false);
        $this->releaseBalance();
    }


    public function releaseBalance()
    {
        if ($this->estadoEncomenda->isFinalState()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($this->linhavendas as $linha) {
                    $perfil = $linha->idvendedor0;
                    if ($perfil) {
                        $perfil->saldo += $linha->idartigo0->precoanuncio;
                        $perfil->saldopendente -= $linha->idartigo0->precoanuncio;
                        $perfil->save(false);
                    }
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }

    public function getOrderSubtotal()
    {
        $userId = $this->idcomprador;
        $linhasVenda = $this->getLinhavendas()->all();
        $subtotalVenda = 0;

        foreach ($linhasVenda as $linha) {
            $artigo = $linha->idartigo0;

            // Soma apenas o preço do anúncio, sem comissões
            $subtotalVenda += $artigo->precoanuncio;
        }

        return $subtotalVenda;
    }




}
