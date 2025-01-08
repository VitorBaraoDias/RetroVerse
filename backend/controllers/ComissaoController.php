<?php

namespace backend\controllers;

use backend\models\SearchComissao;
use common\models\comissao;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ComissaoController implements the CRUD actions for comissao model.
 */
class ComissaoController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('You do not have permission to access this page.');
                },

            ],
        ];
    }

    /**
     * Lists all comissao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('verComissaoLojaBackend')) {

            $searchModel = new SearchComissao();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return die('ola');
    }

    /**
     * Displays a single comissao model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('verDetalhesComissaoLojaBackend')) {

            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        return die('ola');
    }

    /**
     * Creates a new comissao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {

        if (\Yii::$app->user->can('criarComissaoLojaBackend')) {

            $model = new comissao();
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
        return die('ola');

    }

    /**
     * Updates an existing comissao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('alterarComissaoLojaBackend')) {

            $model = $this->findModel($id);
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return die('ola');
    }

    /**
     * Deletes an existing comissao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('alterarComissaoLojaBackend')) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
        return die('eliminarComissaoLojaBackend');
    }

    /**
     * Finds the comissao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return comissao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = comissao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
