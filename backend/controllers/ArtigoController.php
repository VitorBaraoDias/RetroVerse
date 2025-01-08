<?php

namespace backend\controllers;

use app\models\SearchArtigo;
use backend\models\UploadForm;
use backend\models\UploadMultipleForm;
use common\models\Artigo;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ArtigoController implements the CRUD actions for Artigo model.
 */
class ArtigoController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'promotepremium'],
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
     * Lists all Artigo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('verArtigosLojaBackend')) {
            $searchModel = new SearchArtigo();
            if (!isset(Yii::$app->request->queryParams['SearchArtigo']['ativo'])) {
                $searchModel->ativo = 1;
            }
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination = [
                'pageSize' => 6,
            ];
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }
    /**
     * Displays a single Artigo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)

    {
        if (\Yii::$app->user->can('verDetalhesArtigosLojaBackend')) {

            $uploadForm = new UploadMultipleForm();
            return $this->render('view', [
                'model' => $this->findModel($id),
                'uploadForm' => $uploadForm,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }

    }

    /**
     * Creates a new Artigo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('criarArtigosLojaBackend')) {

            $model = new Artigo();
            if ($this->request->isPost) {
                $model->idperfil = Yii::$app->user->id;
                $model->tipoartigo = 'LOJA';
                //buscar a comissao ativa
                //validar as fotos

                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['artigo/view', 'id' => $model->id]);
                }

            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }

    }

    /**
     * Updates an existing Artigo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('alterarArtigosLojaBackend')) {

            $model = $this->findModel($id);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }

    public function actionPromotepremium($id)
    {
        if (\Yii::$app->user->can('alterarArtigosLojaBackend')) {

            $model = $this->findModel($id);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('promotepremium', [
                'model' => $model,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }

    /**
     * Deletes an existing Artigo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {   if (\Yii::$app->user->can('eliminarArtigosLojaBackend')) {

            $model = $this->findModel($id);

            $model->ativo = 0;
            $model->save();

            // Redirecionar para a página que fez a solicitação, ou para 'index' se não houver referrer
            return $this->redirect(Yii::$app->request->referrer ?: ['index']);
        } else {
        throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
    }
    }


    /**
     * Finds the Artigo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Artigo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Artigo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
