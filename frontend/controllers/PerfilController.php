<?php

namespace frontend\controllers;

use common\models\Perfil;
use common\models\UploadSingleForm;
use Yii;
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


        return $this->render('index', [
            'model' => $perfil,
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
        $perfil = Perfil::findOne($id);
        if (!$perfil) {
            Yii::$app->session->setFlash('info', 'Erro: Perfil não encontrado.');
            return $this->redirect(['perfil/index']);
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

                        Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso.');
                        return $this->redirect(['perfil/index']);
                    } else {

                        $uploadForm->deleteImageIfExist($uploadForm->imagePaths[0]);
                        Yii::$app->session->setFlash('error', 'Erro ao salvar perfil.');

                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao fazer upload da imagem.');
                }
            } else {
                // Se não houver arquivo, validar e salvar apenas os outros campos
                if ($perfil->validate() && $perfil->save()) {
                    Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso.');
                    return $this->redirect(['perfil/index']);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao salvar perfil.');
                }
            }
        }

        return $this->render('update', [
            'model' => $perfil,
            'uploadForm' => $uploadForm,
        ]);
    }


    /**
     * Deletes an existing Perfil model.
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
}
