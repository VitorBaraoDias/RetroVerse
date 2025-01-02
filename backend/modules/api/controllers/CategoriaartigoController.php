<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

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
