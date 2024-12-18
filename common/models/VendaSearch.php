<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Venda;


/**
 * VendaSearch represents the model behind the search form of `common\models\Venda`.
 */
class VendaSearch extends Venda
{

    public $tipoVenda;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idcomprador', 'idmetodoexpedicao', 'idtipopagamento', 'idestadoencomenda'], 'integer'],
            [['total'], 'number'],
            [['datavenda', 'nome', 'codigopostal', 'morada', 'pais', 'cidade', 'codigo', 'estadoEncomenda', 'tipoVenda'], 'safe'],
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

        // add conditions that should always apply here

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


        // Filtrar por Compras (idcomprador = usuário logado)
        if (isset($this->tipoVenda) && $this->tipoVenda === 'purchases') {
            $query->andWhere(['idcomprador' => Yii::$app->user->id]);
        }

        // Filtrar por Vendas (usuário é o vendedor nas linhas de venda)
        if (isset($this->tipoVenda) && $this->tipoVenda === 'sales') {
            $query->joinWith('linhavendas l')
                ->andWhere(['l.idvendedor' => Yii::$app->user->id]);
        }

        // Filtrar pelo estado da encomenda
        if ($this->idestadoencomenda) {
            $query->joinWith('estadoEncomenda e')
                ->andWhere(['e.descricao' => $this->estadoEncomenda]);
        }

        return $dataProvider;
    }
}
