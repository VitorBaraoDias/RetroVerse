<?php

namespace backend\modules\api\controllers;

use frontend\models\SignupForm;
use Yii;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    /**
     * Personalizar ações, se necessário
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        return $actions;
    }
    public function actionUsercreate(){

        $model = new SignupForm();

        // Carregar os dados enviados via POST no formulário de registro
        if ($model->load(\Yii::$app->request->post())) {
            var_dump($model);
        }
        return 'erro';
    }
}