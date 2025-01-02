<?php

namespace app\models;

use common\models\Artigo;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchArtigo represents the model behind the search form of common\models\Artigo.
 */
class SearchArtigo extends Artigo
{
    public $tipo; // campo para filtragem (premium ou normal)

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
            [['tipo'], 'string'],
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

        // join com artigospremium para verificar os artigos que sao premium
        $query->joinWith('artigospremium', false);


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

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);

        // filtro para tipo de artigo
        if ($this->tipo === 'premium') {
            $query->andWhere(['IS NOT', 'artigospremium.id', null]);
        } elseif ($this->tipo === 'normal') {
            $query->andWhere(['artigospremium.id' => null]);
        }

        $query->andFilterWhere(['like', 'tipoartigo', $this->tipoartigo]);


        return $dataProvider;
    }
}
