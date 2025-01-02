<?php

namespace frontend\controllers;

use common\models\Conversa;
use common\models\Mensagemtexto;
use Yii;
use yii\data\ActiveDataProvider;
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
     * Lists all Conversa models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Conversa::find(),
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
     * Displays a single Conversa model.
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
     * Creates a new Conversa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        // Criar novo modelo de conversa
        $model = new Conversa();
        $modelTexto = new Mensagemtexto(); // Supondo que o modelo seja Mensagenstextos


        if ($this->request->isPost) {

            // Carregar os dados do formulário nos dois modelos


            if ($modelTexto->load($this->request->post())) {

                // Validar se o campo 'descricao' não está vazio
                if (empty($modelTexto->descricao)) { // Verifica se a mensagem de texto foi preenchida
                    Yii::$app->session->setFlash('error', 'Por favor, insira uma mensagem!');
                    return $this->redirect(['chat/view', 'id' => $id]); // Redireciona se a mensagem estiver vazia
                }
                if ($modelTexto->save()) {

                    $model->idchat = (int)$id;
                    $model->iduser = Yii::$app->user->id;
                    $model->idmensagem = $modelTexto->id;
                    $model->tipo = 'TEXTO';

                    //ver o porqie que nao salva
                    $model->save();
                    if (!$model->save()) {
                        echo $modelTexto->id;
                        var_dump($model->getErrors());
                        die();
                    }
                    return $this->redirect(['chat/view', 'id' => $id]); // Redireciona para a página da conversa
                }
            }
        } else {
            $model->loadDefaultValues();
            $modelTexto->loadDefaultValues(); // Caso o formulário não tenha sido submetido, carrega valores padrão
        }
    }


    /**
     * Updates an existing Conversa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Conversa model.
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
