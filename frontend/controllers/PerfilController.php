<?php

namespace frontend\controllers;

use common\models\Carrinho;
use common\models\Perfil;
use frontend\models\UploadForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
    public function actionIndex()
    {
        $perfil = Perfil::findOne(['id' => Yii::$app->user->id]);


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
            Yii::$app->session->setFlash('info', 'erro');
            return $this->redirect(['site/index']);
        }

        $uploadForm = new UploadForm();
        if (Yii::$app->request->isPost) {
            $perfil->load(Yii::$app->request->post());
            $uploadForm->imageFile = UploadedFile::getInstance($uploadForm, 'imageFile');

            // Validação conjunta do perfil e do upload // verifica se possui alguma foto já
            if ($perfil->validate() && $uploadForm->validate()) {

                $oldProfileimg = $perfil->caminhofotoperfil;
                if($uploadForm->upload()){
                    $perfil->caminhofotoperfil = $uploadForm->imagepath;
                    if ($perfil->save()) {

                        $uploadForm->deleteProfileImageIfExist($oldProfileimg);
                        Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso.');
                        return $this->redirect(['index', 'id' => $perfil->id]);
                    }
                    else{
                        $uploadForm->deleteProfileImageIfExist($perfil->caminhofotoperfil);
                    }
                }
            }
            else{
                Yii::$app->session->setFlash('info', 'erro');
                return $this->redirect(['site/index']);
            }
        }

        // Renderizar o formulário com os dados
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
