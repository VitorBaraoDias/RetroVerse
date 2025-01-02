<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Denuncia;

/**
 * DenunciaSearch represents the model behind the search form of `common\models\Denuncia`.
 */
class DenunciaSearch extends Denuncia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'iddenunciante', 'iddenunciado', 'idartigo', 'descricao'], 'integer'],
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
        $query = Denuncia::find();

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
            'iddenunciante' => $this->iddenunciante,
            'iddenunciado' => $this->iddenunciado,
            'idartigo' => $this->idartigo,
            'descricao' => $this->descricao,
        ]);

        return $dataProvider;
    }
}
