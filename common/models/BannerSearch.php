<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Banner;

/**
 * BannerSearch represents the model behind the search form of `common\models\Banner`.
 */
class BannerSearch extends Banner
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ativo'], 'integer'],
            [['titulo', 'descricao', 'caminhoimagem', 'link'], 'safe'],
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
        $query = Banner::find();

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
            'ativo' => $this->ativo,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'descricao', $this->descricao])
            ->andFilterWhere(['like', 'caminhoimagem', $this->caminhoimagem])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
