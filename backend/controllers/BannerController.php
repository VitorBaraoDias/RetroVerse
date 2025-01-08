<?php

namespace backend\controllers;

use Yii;
use common\models\Banner;
use common\models\BannerSearch;
use common\models\UploadSingleForm;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends Controller
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
     * Lists all Banner models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('verBannerLojaBackend')) {

            $searchModel = new BannerSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }    }

    /**
     * Displays a single Banner model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('verDetalhesBannerLojaBackend')) {

            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        return die('ola');
    }

    /**
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('criarBannerLojaBackend')) {

            $model = new Banner();
            $uploadModel = new UploadSingleForm();

            if ($model->load(Yii::$app->request->post())) {
                // Processa o upload da imagem
                $uploadModel->imageFile = UploadedFile::getInstance($uploadModel, 'imageFile');
                $uploadModel->backendUploadDir = Yii::getAlias('@imageurl/img-banners/');
                $uploadModel->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-banners/');

                if ($uploadModel->upload()) {
                    // Se o upload for bem-sucedido, salva o caminho da imagem no banco de dados
                    $model->caminhoimagem = $uploadModel->imagePaths[0]; // Considera o primeiro arquivo carregado
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            return $this->render('create', [
                'model' => $model,
                'uploadModel' => $uploadModel,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('alterarBannerLojaBackend')) {

            $model = $this->findModel($id);
            $uploadModel = new UploadSingleForm();
            $uploadModel->backendUploadDir = Yii::getAlias('@imageurl/img-banners/');
            $uploadModel->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-banners/');

            if ($this->request->isPost && $model->load($this->request->post())) {
                // Verificar se há uma nova imagem para upload
                $uploadModel->imageFile = UploadedFile::getInstance($uploadModel, 'imageFile');

                if ($uploadModel->imageFile) {
                    // Remover a imagem antiga, se existir
                    if ($model->caminhoimagem) {
                        $uploadModel->deleteImageIfExist($model->caminhoimagem);
                    }

                    // Definir os diretórios de upload
                    $uploadModel->backendUploadDir = Yii::getAlias('@imageurl/img-banners/');
                    $uploadModel->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-banners/');
                    // Fazer o upload da nova imagem
                    if ($uploadModel->upload()) {
                        // Atualiza o campo 'caminhoimagem' com o nome da nova imagem
                        $model->caminhoimagem = $uploadModel->imagePaths[0];
                    }
                }

                // Salva o modelo de Banner (com ou sem imagem)
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            return $this->render('update', [
                'model' => $model,
                'uploadModel' => $uploadModel,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }


    /**
     * Deletes an existing Banner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('eliminarBannerLojaBackend')) {

            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
        else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }

    /**
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
