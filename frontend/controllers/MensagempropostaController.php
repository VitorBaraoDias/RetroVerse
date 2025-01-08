<?php

namespace frontend\controllers;

use common\models\Conversa;
use common\models\Listachats;
use common\models\Mensagemproposta;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MensagempropostaController implements the CRUD actions for Mensagemproposta model.
 */
class MensagempropostaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['create', 'update'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->response->redirect(['site/index']);
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                ],
            ]
        );
    }

    public function actionCreate($id)
    {
        if (\Yii::$app->user->can('CriarMensagemPropostaFrontend')) {

            $conversa = new Conversa();
            $model = new Mensagemproposta();
            $chat = Listachats::findOne($id);
            if(!$chat){
                return Yii::$app->response->redirect(['site/index']);
            }

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {

                    $model->estado = 0;
                    $model->iduser = Yii::$app->user->id;
                    $model->idartigo = $chat->idartigo;
                    $model->idchat = $chat->id;

                    if ($model->save()) {

                        $conversa->idchat = (int)$id;
                        $conversa->iduser = Yii::$app->user->id;
                        $conversa->idmensagem = $model->id;
                        $conversa->tipo = 'PROPOSTA';
                        if ($conversa->save()) {
                            Yii::$app->session->setFlash('sucess', 'Por favor, insira uma mensagem!');
                            return $this->redirect(['chat/view', 'id' => $id]); // Redireciona para a página da conversa

                        }
                    }
                }
            }
            return $this->redirect('chat/view', [
                'id' => $chat->id,
            ]);
        }
        else{
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    public function actionUpdate($id, $state)
    {
        if (\Yii::$app->user->can('alterarMensagemPropostaFrontend')) {

            $model = $this->findModel($id);
            $validStates = [0, 1, 2]; //  0 = Pendente, 1 = Recusado, 2 = Aceite
            if (!in_array($state, $validStates)) {
                throw new \yii\web\ForbiddenHttpException("Invalid state.");
            }
            $model->estado = $state;
            if ($model->save()) {
                Yii::$app->session->setFlash('sucess', 'Proposal sent successfully!');
                return $this->redirect(['chat/view', 'id' => $model->idchat]);
            }
            Yii::$app->session->setFlash('info', 'some error has occurred!');
            return $this->redirect(['chat/view', 'id' => $model->id]);
        }
        else{
            return Yii::$app->response->redirect(['site/login']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Mensagemproposta::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
