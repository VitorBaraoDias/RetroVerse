<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use yii\rest\ActiveController;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `api` module
 */
class ArtigoController extends ActiveController
{
    //modelo a criar artigo
    public $modelClass = 'common\models\Artigo';


    public function BeforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->request->method !== 'GET') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'Este método não é permitido.'
            ];
            return false;
        }
        return true;
    }

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
