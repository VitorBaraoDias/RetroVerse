<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Artigo;

/**
 * SearchArtigo represents the model behind the search form of `common\models\Artigo`.
 */
class SearchArtigo extends Artigo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idcomissao', 'idestado', 'idmarca', 'idcategoria', 'idtamanho', 'idperfil', 'ativo'], 'integer'],
            [['nome', 'descricao'], 'string', 'max' => 255],
            [['precoanuncio'], 'number'],
            [['tipoartigo'], 'safe'],
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
        $query = Artigo::find();

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
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'precoanuncio' => $this->precoanuncio,
            'idcomissao' => $this->idcomissao,
            'idestado' => $this->idestado,
            'idmarca' => $this->idmarca,
            'idcategoria' => $this->idcategoria,
            'idtamanho' => $this->idtamanho,
            'idperfil' => $this->idperfil,
            'ativo' => $this->ativo,
        ]);

        $query->andFilterWhere(['like', 'tipoartigo', $this->tipoartigo]);

        return $dataProvider;
    }
}
