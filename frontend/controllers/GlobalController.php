<?php

namespace frontend\controllers;

use yii\base\Controller;

class GlobalController extends Controller
{

    public function render($view, $params = [])
    {

//        if (!Yii::$app->user->isGuest) {
//
//            $carrinho = Carrinho::findOne(['iduser' => Yii::$app->user->id]);
//
//            $params['carrinho'] = $carrinho;
//
//        }

        return parent::render($view, $params);
    }
}