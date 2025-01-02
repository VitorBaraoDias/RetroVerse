<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * VendaSearch represents the model behind the search form of `common\models\Venda`.
 */
class VendaSearch extends Venda
{

    public $statusFilter;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idcomprador', 'idmetodoexpedicao', 'idtipopagamento', 'idestadoencomenda'], 'integer'],
            [['total'], 'number'],
            [['statusFilter'], 'safe'],
            [['datavenda', 'nome', 'codigopostal', 'morada', 'pais', 'cidade', 'codigo', 'estadoEncomenda'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Venda::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'idcomprador' => $this->idcomprador,
            'idmetodoexpedicao' => $this->idmetodoexpedicao,
            'idtipopagamento' => $this->idtipopagamento,
            'total' => $this->total,
            'datavenda' => $this->datavenda,
            'idestadoencomenda' => $this->idestadoencomenda,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'codigopostal', $this->codigopostal])
            ->andFilterWhere(['like', 'morada', $this->morada])
            ->andFilterWhere(['like', 'pais', $this->pais])
            ->andFilterWhere(['like', 'cidade', $this->cidade])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);


            $query->andWhere(['idcomprador' => Yii::$app->user->id]);

        $query->orderBy(['datavenda' => SORT_DESC]);


        // filtrar pelo estado da encomenda
        $estados = Estadoencomenda::find()->orderBy(['status' => SORT_ASC])->all();

        $primeiroEstado = $estados[0] ?? null;
        $penultimoEstado = $estados[count($estados) - 2] ?? null;
        $ultimoEstado = Estadoencomenda::find()->orderBy(['status' => SORT_DESC])->one();


        //encomendas que nao estao concluidas
        if ($this->statusFilter === 'accepted') {
            if ($primeiroEstado && $penultimoEstado) {
                $query->andWhere(['in', 'vendas.idestadoencomenda', [
                    $primeiroEstado->id,
                    $penultimoEstado->id
                ]]);
            }
        }

        //encomendas completas
        if ($this->statusFilter === 'completed') {
            if ($ultimoEstado) {
                $query->andWhere(['vendas.idestadoencomenda' => $ultimoEstado->id]);
            }
        }


        return $dataProvider;
    }
}
