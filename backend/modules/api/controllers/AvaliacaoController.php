<?php
namespace backend\modules\api\controllers;

use common\models\Avaliacao;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use backend\modules\api\components\CustomAuth;
use yii\web\ForbiddenHttpException;

use yii\web\NotFoundHttpException;
/**
 * Default controller for the `api` module
 */
class AvaliacaoController extends ActiveController
{
    public $modelClass = 'common\models\Avaliacao';
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
            if ($action === 'create') {
                if ($model) {
                    $linhaVenda = $model->linhavenda;
                    if ($linhaVenda) {
                        $venda = $linhaVenda->idvenda0;
                        if ($venda) {
                            if ($venda->idcomprador === $this->user->id) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You do not have permission to create this evaluation.');
                            }
                        } else {
                            throw new ForbiddenHttpException('Associated sale not found.');
                        }
                    } else {
                        throw new ForbiddenHttpException('Associated sale line not found.');
                    }
                } else {
                    throw new ForbiddenHttpException('Invalid evaluation.');
                }
            }

        } else {
            throw new ForbiddenHttpException('User not authenticated.');
        }
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->request->method !== 'GET' && Yii::$app->request->method !== 'POST') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'THIS METHOD IS NOT ALLOWED!'
            ];
            return false;
        }
        return true;
    }

    public function actionAvaliacoesuser($id)
    {
        $avaliacoes = Avaliacao::find()
            ->where(['iddestinatario' => $id])
            ->with(['remetente.user', 'destinatario.user'])
            ->all();

        if (empty($avaliacoes)) {
            throw new NotFoundHttpException('No rating found for this user.');
        }

        $resultados = [];
        foreach ($avaliacoes as $avaliacao) {
            $resultados[] = [
                'id' => $avaliacao->id,
                'remetente' => [
                    'id' => $avaliacao->idremetente,
                    'username' => $avaliacao->remetente->user->username,
                ],
                'destinatario' => [
                    'id' => $avaliacao->iddestinatario,
                    'username' => $avaliacao->destinatario->user->username,
                ],
                'comentario' => $avaliacao->descricao,
                'escala' => $avaliacao->escala,
            ];
        }

        return $resultados;
    }


    public function actionCriaravaliacao()
    {
        $request = Yii::$app->getRequest();
        $data = $request->getBodyParams();

        $avaliacao = new Avaliacao();
        $avaliacao->load($data, '');

        $existingAvaliacao = Avaliacao::find()
            ->where([
                'idlinhavenda' => $avaliacao->idlinhavenda,
                'idremetente' => $this->user->id
            ])
            ->one();

        if ($existingAvaliacao) {
            return $this->asJson([
                'success' => false,
                'message' => 'You have already rated this purchase!'
            ]);
        }


        $this->checkAccess('create', $avaliacao);

        if ($avaliacao->save()) {
            Yii::$app->response->statusCode = 201;
            return $avaliacao;
        } else {
            return $this->asJson(['errors' => $avaliacao->errors]);
        }
    }


}
