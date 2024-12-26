<?php

namespace backend\modules\api\controllers;

use common\models\Perfil;
use Yii;
use yii\rest\ActiveController;
use common\models\User;
use yii\web\Response;
use function Psy\debug;

/** * Default controller for the `api` module */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

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
        throw new \yii\web\ForbiddenHttpException('No authentication');
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
                'message' => 'Os campos username, email e password são obrigatórios.'
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
            if (!$perfil->save(false)) {
                $transaction->rollBack();
                return null;
            }
            $transaction->commit();
            return $user->save();

        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
            return null;
        }
    }
}

?>