<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LinhavendaSearch represents the model behind the search form of `common\models\Linhavenda`.
 */
class LinhavendaSearch extends Linhavenda
{

    public $statusFilter, $orderNumber;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idvenda', 'idartigo', 'idvendedor', 'idestadoencomenda'], 'integer'],
            [['statusFilter', 'orderNumber'], 'safe'],
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
        $query = Linhavenda::find();

        $query->andWhere(['idvendedor' => \Yii::$app->user->id]);

        // ordenar por vendas mais recentes
        $query->leftJoin('vendas', 'linhavendas.idvenda = vendas.id')
            ->orderBy(['vendas.datavenda' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere([
            'id' => $this->id,
            'idvenda' => $this->idvenda,
            'idartigo' => $this->idartigo,
            'idvendedor' => $this->idvendedor,
            'linhavendas.idestadoencomenda' => $this->idestadoencomenda,
        ]);


        // filtrar pelo estado da encomenda
        $estados = Estadoencomenda::find()->orderBy(['status' => SORT_ASC])->all();

        $primeiroEstado = $estados[0] ?? null;
        $penultimoEstado = $estados[count($estados) - 2] ?? null;
        $ultimoEstado = Estadoencomenda::find()->orderBy(['status' => SORT_DESC])->one();

        //encomendas que nao estao concluidas
        if ($this->statusFilter === 'accepted') {
            if ($primeiroEstado && $penultimoEstado) {
                $query->andWhere(['in', 'linhavendas.idestadoencomenda', [
                    $primeiroEstado->id,
                    $penultimoEstado->id
                ]]);
            }
        }

        //encomendas completas
        if ($this->statusFilter === 'completed') {
            if ($ultimoEstado) {
                $query->andWhere(['linhavendas.idestadoencomenda' => $ultimoEstado->id]);
            }
        }

        if (!empty($this->orderNumber)) {
            $query->andFilterWhere(['like', 'vendas.codigo', $this->orderNumber]);
        }

        return $dataProvider;
    }
}