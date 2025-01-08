<?php

namespace backend\controllers;
use backend\models\UploadMultipleForm;
use common\models\Fotosartigo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * FotoartigoController implements the CRUD actions for Fotosartigo model.
 */
class FotoartigoController extends Controller
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
                        'actions' => ['create', 'delete'],
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
     * Lists all Fotosartigo models.
     *
     * @return string
     */

    /**
     * Displays a single Fotosartigo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Creates a new Fotosartigo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        if (\Yii::$app->user->can('criarfotoArtigoLojaBackend')) {

            $model = new UploadMultipleForm();
            $model->backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');
            $model->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');
            if (Yii::$app->request->isPost && $model->load($this->request->post())) {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if ($model->upload($id)) {
                    // file is uploaded successfully
                    return $this->redirect(['artigo/view', 'id' => $id]);
                }
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        return die('ola');
    }


    /**
     * Deletes an existing Fotosartigo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('eliminarfotoArtigoLojaBackend')) {

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
                return $this->redirect(['artigo/view', 'id' => $model->idartigo]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->redirect(['artigo/view', 'id' => $model->idartigo]);
            }
        }
        return die('ola');
    }

    /**
     * Finds the Fotosartigo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Fotosartigo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fotosartigo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
