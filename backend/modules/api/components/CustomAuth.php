<?php

namespace backend\modules\api\components;
use yii\filters\auth\AuthMethod;
use Yii;

class CustomAuth extends AuthMethod
{
    public $auth; //para chamar função do controlador
    public function authenticate($user, $request, $response)
    {
        $strToken = Yii::$app->request->getQueryParam('access-token');
        if ($this->auth)
        {
            $identity = call_user_func($this->auth, $strToken);
            if ($identity === null) {
                return null;
            }
            return $identity;
        }
        return null;
    }
}

