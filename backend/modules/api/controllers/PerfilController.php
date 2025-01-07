<?php

namespace backend\modules\api\controllers;

use common\models\Favorito;
use common\models\Perfil;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use backend\modules\api\components\CustomAuth;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `api` module
 */
class PerfilController extends ActiveController
{
    public $modelClass = 'common\models\Perfil';
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
        if (Yii::$app->request->method !== 'GET' && Yii::$app->request->method !== 'PUT') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'THIS METHOD IS NOT ALLOWED!'
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
            //proibir get de todos os perfis existentes exceto ao admin
            if ($action === 'index' && $this->user->id != 1) {
                throw new ForbiddenHttpException('You don´t have permission to do this action!');
            }

            if ($action === 'update' && $model->id !== $this->user->id) {
                throw new ForbiddenHttpException('You do not have permission to do this action!');
            }

        } else {
            throw new ForbiddenHttpException('User not authenticated.');
        }
    }

    public function actionEditarperfil($id)
    {
        $perfil = Perfil::findOne($id);

        $this->checkAccess('update', $perfil);

        if (!$perfil) {
            throw new NotFoundHttpException('Profile not found.');
        }


        $perfil->setScenario('updateProfile');

        $perfil->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($perfil->save()) {
            return [
                'success' => true,
                'message' => 'Profile updated successfully!',
            ];
        } else {
            return $this->asJson(['errors' => $perfil->errors]);
        }
    }
}
