<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class VendaController extends ActiveController
{
    //modelo a criar artigo
    public $modelClass = 'common\models\Venda';
}
