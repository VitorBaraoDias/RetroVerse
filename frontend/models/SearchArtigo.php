<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Artigo;

/**
 * SearchArtigo represents the model behind the search form of common\models\Artigo.
 */
class SearchArtigo extends Artigo
{
    public $tipo; // Campo para filtro (premium ou normal)
    public $preco_min;
    public $preco_max;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idcomissao', 'idestado', 'idmarca', 'idcategoria', 'idtamanho', 'idperfil', 'ativo'], 'integer'],
            [['nome', 'descricao'], 'string', 'max' => 255],
            [['precoanuncio'], 'number'],
            [['preco_min', 'preco_max'], 'number'],
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

        // Junta com a tabela Artigospremium para verificar os artigos premium
        $query->joinWith('artigospremium', false);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filtros existentes para os campos do artigo
        $query->andFilterWhere([
            'id' => $this->id,
            'idcomissao' => $this->idcomissao,
            'idestado' => $this->idestado,
            'idmarca' => $this->idmarca,
            'idcategoria' => $this->idcategoria,
            'idtamanho' => $this->idtamanho,
            'idperfil' => $this->idperfil,
            'ativo' => $this->ativo,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);

        // Filtro de preço
        if (!is_null($this->preco_min) && !is_null($this->preco_max)) {
            $query->andFilterWhere(['>=', 'precoanuncio', $this->preco_min])
                ->andFilterWhere(['<=', 'precoanuncio', $this->preco_max]);
        }

        // Filtro para tipo de artigo
        if ($this->tipo === 'premium') {
            $query->andWhere(['IS NOT', 'artigospremium.id', null]); // Artigos premium
        } elseif ($this->tipo === 'normal') {
            $query->andWhere(['artigospremium.id' => null]); // Artigos normais (sem correspondência na tabela premium)
        }

        return $dataProvider;
    }
}
