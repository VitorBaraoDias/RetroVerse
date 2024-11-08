<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;

/**
 * Default controller for the `api` module
 */
class ArtigoController extends ActiveController
{
    //modelo a criar artigo
    public $modelClass = 'common\models\User';
}
