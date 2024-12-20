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

    public function checkAndSetFinalState()
    {
        if ($this->estadoEncomenda->isFinalState()) {
            return;
        }

        $items = $this->linhavendas;

        // Verifique se todos os itens têm o estado final
        $allItemsState = true;

        foreach ($items as $item) {
            // Verifique se o estado do item é final
            if (!$item->idestadoencomenda0->isFinalState()) {
                $allItemsState = false;
                break;
            }
        }

        // Se todos os itens estão no estado final, altere o estado da venda para "final"
        if ($allItemsState) {
            // Atualize o estado da venda
            $this->idestadoencomenda = 2;
            $this->save();  // Salve a venda com o novo estado
        }
    }


}
