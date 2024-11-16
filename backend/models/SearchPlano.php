<?php

namespace app\models;

use common\models\Plano;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchPlano represents the model behind the search form of `app\models\Plano`.
 */
class SearchPlano extends Plano
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idiva'], 'integer'],
            [['precomensal'], 'number'],
            [['descricao'], 'safe'],
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
        $query = Plano::find();

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
            'precomensal' => $this->precomensal,
            'idiva' => $this->idiva,
        ]);

        $query->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
}
