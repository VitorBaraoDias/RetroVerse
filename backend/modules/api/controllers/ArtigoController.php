<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use yii\rest\ActiveController;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class ArtigoController extends ActiveController
{
    //modelo a criar artigo
    public $modelClass = 'common\models\Artigo';

    public function actionArtigofiltro($tipo = null, $tamanho = null, $estado = null, $marca = null)
    {
        $query = Artigo::find()
            ->joinWith(['idestado0', 'idmarca0', 'idtamanho0'])
            ->andFilterWhere(['tipoartigo' => $tipo])
            ->andFilterWhere(['Tamanhos.tamanho' => $tamanho])
            ->andFilterWhere(['Estados.descricao' => $estado])
            ->andFilterWhere(['Marcas.nome' => $marca]);
        return $query->all();
    }
}
