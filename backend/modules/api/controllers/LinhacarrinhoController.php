<?php

namespace backend\modules\api\controllers;

use common\models\Carrinho;
use common\models\User;
use common\models\Linhascarrinho;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use backend\modules\api\components\CustomAuth;


/**
 * Default controller for the `api` module
 */
class LinhacarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\Carrinho';
    public $user = null;


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            'auth' => [$this, 'authCustom'],
        ];
        return $behaviors;
    }
    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->request->method !== 'DELETE' && Yii::$app->request->method !== 'GET') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'success' => false,
                'message' => 'METHOD NOT ALLOWED.',
            ];
            return false;
        }

        return true;
    }

    public function authCustom($token)
    {
        $user_ = \common\models\User::findIdentityByAccessToken($token);
        if($user_) {
            $this->user=$user_;
            return $user_;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication');
    }


    public function checkAccess($action, $model = null, $params = [])
    {
        if ($this->user) {
            if ($action === 'delete' || $action === 'view') {
                if ($model && $model->carrinho->iduser != $this->user->id) {
                    throw new \yii\web\ForbiddenHttpException('You don´t have permission to do this action!');
                }
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('User not authenticated.');
        }
    }

    public function actionDeletelinhacarrinho($idartigo)
    {
        $carrinho = Carrinho::findOne(['iduser' => $this->user->id]);

        if (!$carrinho) {
            throw new \yii\web\ForbiddenHttpException('This user doesn´t have a cart.');
        }

        $linhaCarrinho = Linhascarrinho::findOne(['idcarrinho' => $carrinho->id, 'idartigo' => $idartigo]);

        if (!$linhaCarrinho) {
            throw new \yii\web\ForbiddenHttpException('This item is not in the cart for this user.');
        }

        $this->checkAccess('delete', $linhaCarrinho);

        if ($linhaCarrinho->delete()) {
            return [
                'status' => 'success',
                'message' => 'Item successfully removed from cart.',
            ];
        } else {
            throw new \yii\web\ServerErrorHttpException('Failed to delete the item from the cart.');
        }
    }
}
