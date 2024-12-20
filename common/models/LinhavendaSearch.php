<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Linhavenda;

/**
 * LinhavendaSearch represents the model behind the search form of `common\models\Linhavenda`.
 */
class LinhavendaSearch extends Linhavenda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idvenda', 'idartigo', 'idvendedor'], 'integer'],
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

        $query->leftJoin('vendas', 'linhavendas.idvenda = vendas.id')
            ->where(['idvendedor' => 1])
            ->orderBy(['vendas.datavenda' => SORT_DESC]);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Retorna os dados sem filtros adicionais caso a validação falhe
            return $dataProvider;
        }

        // Condições de filtro da grid
        $query->andFilterWhere([
            'id' => $this->id,
            'idvenda' => $this->idvenda,
            'idartigo' => $this->idartigo,
            'idvendedor' => $this->idvendedor,
        ]);

        return $dataProvider;
    }
}
