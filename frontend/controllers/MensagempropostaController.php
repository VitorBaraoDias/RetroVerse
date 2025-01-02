<?php

namespace frontend\controllers;

use common\models\Conversa;
use common\models\Listachats;
use common\models\Mensagemproposta;
use Yii;
use yii\data\ActiveDataProvider;
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
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Mensagemproposta models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Mensagemproposta::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mensagemproposta model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mensagemproposta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $conversa = new Conversa();
        $model = new Mensagemproposta();
        $chat = Listachats::findOne($id);

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

    /**
     * Updates an existing Mensagemproposta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $state)
    {
        $model = $this->findModel($id);

        $validStates = [0, 1, 2]; // Por exemplo, 0 = Pendente, 1 = Recusado, 2 = Aceite
        if (!in_array($state, $validStates)) {
            throw new \yii\web\BadRequestHttpException("Estado inválido.");
        }

        // Atualiza o estado
        $model->estado = $state;
        if ($model->save()) {
            Yii::$app->session->setFlash('sucess', 'Proposal sent successfully!');
            return $this->redirect(['chat/view', 'id' => $model->idchat]);
        }
        Yii::$app->session->setFlash('info', 'some error has occurred!');
        return $this->redirect(['chat/view', 'id' => $model->id]);
    }

    /**
     * Deletes an existing Mensagemproposta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mensagemproposta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Mensagemproposta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mensagemproposta::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
