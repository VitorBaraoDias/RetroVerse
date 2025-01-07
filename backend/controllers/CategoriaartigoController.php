<?php

namespace backend\controllers;

use common\models\Categoriaartigo;
use common\models\SearchCategoriaartigo;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CatergoriaartigoController implements the CRUD actions for Categoriaartigo model.
 */
class CategoriaartigoController extends Controller
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
                            'actions' => ['index','view','delete', 'update','create'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new \Exception('Você não está autorizado a acessar esta página');
                    }

                ],
            ]
        );
    }

    /**
     * Lists all Categoriaartigo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('verCategoriaBackend')) {

            $searchModel = new SearchCategoriaartigo();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return die('nao tem permissao amigo');

    }

    /**
     * Displays a single Categoriaartigo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('verDetalhesCategoriaBackend')) {

            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        return die('nao tem permissao amigo');

    }

    /**
     * Creates a new Categoriaartigo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        if (\Yii::$app->user->can('criarCategoriasBackend')) {

            $model = new Categoriaartigo();
            if ($this->request->isPost) {

                $model->ativo = true;

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
        return die('nao tem permissao amigo');

    }

    /**
     * Updates an existing Categoriaartigo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('alterarCategoriasBackend')) {

            $model = $this->findModel($id);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return die('nao tem permissao amigo');

    }

    /**
     * Deletes an existing Categoriaartigo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('eliminarCategoriasBackend')) {

            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }
        return die('nao tem permissao amigo');

    }

    /**
     * Finds the Categoriaartigo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Categoriaartigo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categoriaartigo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
