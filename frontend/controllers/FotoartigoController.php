<?php

namespace frontend\controllers;
use backend\models\UploadMultipleForm;
use common\models\Fotosartigo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


class FotoartigoController extends Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['create','update','delete'],
                            'allow' => true,
                            'roles' => ['membro'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->response->redirect(['site/login']);
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                    ],
                ],
            ]
        );
    }

    public function actionCreate($id)
    {
        if (Yii::$app->user->can('criarFotoartigoFrontend')) {
            $model = new UploadMultipleForm();
            $model->backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');
            $model->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');
            if (Yii::$app->request->isPost && $model->load($this->request->post())) {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if ($model->upload($id)) {
                    return $this->redirect(['artigo/view', 'id' => $id]);
                }
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('alterarFotoartigoFrontend')) {
            $model = $this->findModel($id);
            $model->backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');
            $model->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if ($model->upload($id)) {
                    // file is uploaded successfully
                    return $this->redirect(['artigo/view', 'id' => $id]);
                }
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->can('eliminarFotoartigoFrontend')) {
            $model = $this->findModel($id);
            $modelForm = new UploadMultipleForm();
            $modelForm->backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');
            $modelForm->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $this->findModel($id)->delete();

                if (!$modelForm->removeFoto($model->caminhofoto)) {
                    $transaction->rollBack();
                }
                $transaction->commit();
                return $this->redirect(['artigo/update', 'id' => $model->idartigo]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->redirect(['artigo/view', 'id' => $model->idartigo]);
            }
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Fotosartigo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
