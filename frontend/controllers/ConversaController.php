<?php

namespace frontend\controllers;

use common\models\Conversa;
use common\models\Mensagemtexto;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ConversaController implements the CRUD actions for Conversa model.
 */
class ConversaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect(['site/login']);
                }
            ],
        ];
    }
    public function actionCreate($id)
    {
        if (\Yii::$app->user->can('CriarConversaFrontend')) {

            $model = new Conversa();
            $modelTexto = new Mensagemtexto();

            if ($this->request->isPost) {

                if ($modelTexto->load($this->request->post())) {
                    if (empty($modelTexto->descricao)) {
                        Yii::$app->session->setFlash('error', 'Por favor, insira uma mensagem!');
                        return $this->redirect(['chat/view', 'id' => $id]);
                    }
                    if ($modelTexto->save()) {
                        $model->idchat = (int)$id;
                        $model->iduser = Yii::$app->user->id;
                        $model->idmensagem = $modelTexto->id;
                        $model->tipo = 'TEXTO';
                        $model->save();
                        if (!$model->save()) {
                            die();
                        }
                        return $this->redirect(['chat/view', 'id' => $id]);
                    }
                }
            } else {
                $model->loadDefaultValues();
                $modelTexto->loadDefaultValues();
            }
        }
        else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }

    /**
     * Finds the Conversa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Conversa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Conversa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
