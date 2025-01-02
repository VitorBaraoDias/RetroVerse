<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class VendaController extends ActiveController
{
    //modelo a criar artigo
    public $modelClass = 'common\models\Venda';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        return $actions;
    }
    public function actionCompras($id){

        die('ola');
    }
    public function actionVendas($id){

        die('ola2');
    }
}
