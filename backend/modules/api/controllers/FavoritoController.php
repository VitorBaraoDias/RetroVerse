<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `api` module
 */
class FavoritoController extends ActiveController
{
    public $modelClass = 'common\models\Favorito';


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            //'only' => ['favorito'], // Aplicar autenticação apenas ao método 'favorito'
        ];
        return $behaviors;
    }

    public function actionFavorito($id)
    {
        $modelClass = $this->modelClass;
        $favorito = $modelClass::find()->where(['idperfil' => $id])->all(); // Ajuste de coluna

        if (empty($favorito)) {
            return ['message' => 'No favorites found for this user.', 'status' => 404];
        }

        return $favorito;
    }
}
