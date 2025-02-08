<?php

namespace frontend\controllers;

use common\models\Perfil;
use common\models\Seguidor;
use common\models\UploadSingleForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PerfilController implements the CRUD actions for Perfil model.
 */
class PerfilController extends Controller
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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['view'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                        [
                            'actions' => ['index','view','update', 'followers', 'following', 'edit-shipping'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->response->redirect(['site/login']);
                    },
                ],
            ]
        );
    }

    /**
     * Lists all Perfil models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $perfil = Perfil::findOne(['id' => $id]);

        $quantidadeSeguidores = Seguidor::find()
            ->where(['idperfil' => $id])
            ->count();

        $quantidadeSeguir = Seguidor::find()
            ->where(['idseguidor' => $id])
            ->count();

        $isFollowing = Seguidor::find()
            ->where(['idperfil' => $id, 'idseguidor' => Yii::$app->user->id])
            ->exists();

        return $this->render('index', [
            'model' => $perfil,
            'quantidadeSeguidores' => $quantidadeSeguidores,
            'quantidadeSeguir' => $quantidadeSeguir,
            'isFollowing' => $isFollowing,
        ]);
    }


    /**
     * Displays a single Perfil model.
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
     * Creates a new Perfil model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    /**
     * Updates an existing Perfil model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('alterarPerfilFrontend')) {

            $perfil = Perfil::findOne($id);
        if (!$perfil) {
            Yii::$app->session->setFlash('info', 'Error: Profile Not Found.');
            return $this->redirect(['perfil/index', 'id' => $id]);
        }

        $uploadForm = new UploadSingleForm();

        if (Yii::$app->request->isPost) {
            $perfil->load(Yii::$app->request->post());

            $uploadForm->backendUploadDir = Yii::getAlias('@imageurl/img-profile/');
            $uploadForm->frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-profile/');

            $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');

            if ($uploadForm->imageFile) {
                if ($perfil->validate() && $uploadForm->validate() && $uploadForm->upload()) {
                    $oldProfileImg = $perfil->caminhofotoperfil;

                    $perfil->caminhofotoperfil = $uploadForm->imagePaths[0];

                    if ($perfil->save()) {
                        $uploadForm->deleteImageIfExist($oldProfileImg);

                        Yii::$app->session->setFlash('success', 'Profile updated with success.');
                        return $this->redirect(['perfil/index', 'id' => $perfil->id]);
                    } else {
                        $uploadForm->deleteImageIfExist($uploadForm->imagePaths[0]);
                        Yii::$app->session->setFlash('error', 'Error saving this profile.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Error uploading this image.');
                }
            } else {
                if ($perfil->validate() && $perfil->save()) {
                    Yii::$app->session->setFlash('success', 'Profile updated with success.');
                    return $this->redirect(['perfil/index', 'id' => $perfil->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Error saving profile.');
                }
            }
        }

        return $this->render('update', [
            'model' => $perfil,
            'uploadForm' => $uploadForm,
        ]); } else {
                return Yii::$app->response->redirect(['site/login']);
            }
    }

    /**
     * Finds the Perfil model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Perfil the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Perfil::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFollowers($id)
    {
        $perfil = Perfil::findOne($id);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Seguidor::find()->where(['idperfil' => $id]),
        ]);

        return $this->render('followers', [
            'perfil' => $perfil,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFollowing($id)
    {
        $perfil = Perfil::findOne($id);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Seguidor::find()->where(['idseguidor' => $id]),
        ]);


        return $this->render('following', [
            'perfil' => $perfil,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEditShipping()
    {
        $model = Perfil::findOne(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Shipping details updated successfully!');
            return $this->redirect(['perfil/update', 'id' => $model->id]);
        }

        return $this->render('edit-shipping', [
            'model' => $model,
        ]);
    }
}
