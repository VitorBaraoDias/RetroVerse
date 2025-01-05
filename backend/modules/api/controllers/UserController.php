<?php

namespace backend\modules\api\controllers;

use common\models\Perfil;
use common\models\User;
use Yii;
use yii\rest\ActiveController;

/** * Default controller for the `api` module */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function actionLogin()
    {
        $request = Yii::$app->request->post();
        $username = $request['username'] ?? null;
        $password = $request['password'] ?? null;
        $user = User::findByUsername($username);


        if ($user && $user->validatePassword($password))
        {
            return ['auth_key' => $user->auth_key];
        }
        throw new \yii\web\ForbiddenHttpException('Invalid');
    }

    public function actionUsercreate()
    {
        $request = Yii::$app->request->post();

        $username = $request['username'] ?? null;
        $email = $request['email'] ?? null;
        $password = $request['password'] ?? null;

        // Verificar se os campos obrigatórios foram preenchidos
        if (!$username || !$email || !$password) {
            return [
                'status' => 'error',
                'message' => 'Fields username, email and password are required.'

            ];
        }
        

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->status = 10;
            $user->username = $username;
            $user->email = $email;
            $user->setPassword($password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->save(false);


            $auth = Yii::$app->authManager;
            $authorRole = $auth->getRole('membro');
            if ($authorRole) {
                $auth->assign($authorRole, $user->getId());
            }
            $perfil = new Perfil();
            $perfil->id = $user->getId();
            $perfil->banido = 0;
            if (!$perfil->save(false)) {
                $transaction->rollBack();
                throw new \yii\web\ForbiddenHttpException('Invalid');
            }
            $transaction->commit();
            return ['auth_key' => $user->auth_key];
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new \yii\web\ForbiddenHttpException('Invalid');
        }
    }
}

?>