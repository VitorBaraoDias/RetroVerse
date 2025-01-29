<?php

namespace frontend\models;

use common\models\Artigo;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchArtigo represents the model behind the search form of common\models\Artigo.
 */
class SearchArtigo extends Artigo
{
    public $tipo;
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

        $query->joinWith('artigospremium', false);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            Yii::debug("Validation failed: " . json_encode($this->errors), __METHOD__);
            return $dataProvider;
        }

        $query->andWhere(['!=', 'idperfil', Yii::$app->user->id ?? 0]);

        $query->andFilterWhere([
            'id' => $this->id,
            'idcomissao' => $this->idcomissao,
            'idestado' => $this->idestado,
            'idmarca' => $this->idmarca,
            'idcategoria' => $this->idcategoria,
            'idtamanho' => $this->idtamanho,
            'ativo' => $this->ativo,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);


        if (!is_null($this->preco_min) && !is_null($this->preco_max)) {
            $query->andFilterWhere(['>=', 'precoanuncio', $this->preco_min])
                ->andFilterWhere(['<=', 'precoanuncio', $this->preco_max]);
        }

        if ($this->tipo === 'premium') {
            $query->andWhere(['IS NOT', 'artigospremium.id', null]);
        } elseif ($this->tipo === 'normal') {
            $query->andWhere(['artigospremium.id' => null]);
        }

        $query->andFilterWhere(['like', 'tipoartigo', $this->tipoartigo]);

        return $dataProvider;
    }


}
