<?php

namespace backend\controllers;

use common\models\SearchTamanho;
use common\models\Tamanho;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TamanhoController implements the CRUD actions for Tamanho model.
 */
class TamanhoController extends Controller
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
                            'actions' => ['login', 'error', 'logout'],
                            'allow' => true,
                            'roles' => ['?', "@"],
                        ],
                        [
                            'actions' => ['index','view','delete', 'update','create'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new \Exception('Você não está autorizado a acessar esta página');
                    }

                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Tamanho models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('verTamanhoBackend')) {
            $searchModel = new SearchTamanho();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return die("sla");
    }

    /**
     * Displays a single Tamanho model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('verDetalhesTamanhoBackend')) {

            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        return dirname('sla');
    }

    /**
     * Creates a new Tamanho model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('criarTamanhoBackend')) {
            $model = new Tamanho();
            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        return die('sla');
    }

    /**
     * Updates an existing Tamanho model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('alterarTamanhosBackend')) {

            $model = $this->findModel($id);
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return die('ooa');
    }

    /**
     * Deletes an existing Tamanho model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('eliminarTamanhosBackend')) {

            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        return die('ola');
    }

    /**
     * Finds the Tamanho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tamanho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tamanho::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
