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
        $favorito = $modelClass::find()->where(['user_id' => $id])->all(); // Ajuste de coluna

        if (empty($favorito)) {
            return ['message' => 'No favorites found for this user.', 'status' => 404];
        }

        return $favorito;
    }

    public function actionDeleteFavorito($id)
    {
        $modelClass = $this->modelClass;

        $favorito = $modelClass::findOne($id);

        if (!$favorito) {
            return ['message' => 'Favorite not found.', 'status' => 404];
        }

        if ($favorito->delete()) {
            return ['message' => 'Favorite deleted successfully.', 'status' => 200];
        }

        return ['message' => 'Failed to delete favorite.', 'status' => 500];
    }

}
