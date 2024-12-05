<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class EstadoController extends ActiveController
{
    public $modelClass = 'common\models\Estado';

    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->request->method !== 'GET') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'Este método não é permitido.',
            ];
            return false;
        }

        return true;
    }

}