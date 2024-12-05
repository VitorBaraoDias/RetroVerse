<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `api` module
 */
class CategoriaartigoController extends ActiveController
{
    public $modelClass = 'common\models\Categoriaartigo';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'only'=> ['index'], //Apenas para o GET
        ];
        return $behaviors;
    }



    public function BeforeAction ($action)
    {
        if(!parent::beforeAction($action)) {
            return false;
        }

        if(Yii::$app->request->method != 'GET') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'Este método não é permitido. ',
            ];
            return false;
        }

        return true;

    }
}
