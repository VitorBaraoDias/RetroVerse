<?php

namespace backend\controllers;

use Yii;
use common\models\Denuncia;
use common\models\User;
use common\models\Artigo;
use common\models\DenunciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DenunciaController implements the CRUD actions for Denuncia model.
 */
class DenunciaController extends Controller
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
     * Lists all Denuncia models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DenunciaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Denuncia model.
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
     * Creates a new Denuncia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Denuncia();

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

    /**
     * Updates an existing Denuncia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Denuncia model.
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
     * Finds the Denuncia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Denuncia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Denuncia::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMarkasresolved($id)
    {
        $model = $this->findModel($id);

        if (!$model->estado) { // Apenas se ainda não estiver resolvido
            $model->estado = 1;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Denúncia marcada como resolvida.');
            } else {
                Yii::$app->session->setFlash('error', 'Não foi possível marcar a denúncia como resolvida.');
            }
        } else {
            Yii::$app->session->setFlash('info', 'Esta denúncia já está marcada como resolvida.');
        }

        return $this->redirect(['index']);
    }

    public function actionBanUser($id)
    {
        // Encontrar a denúncia com o id fornecido
        $model = $this->findModel($id);

        // Verificar se a denúncia está resolvida
        if ($model->estado != 1) {
            // Alterar o estado da denúncia para resolvido
            $model->estado = 1;
            $model->save();
        }

        // Buscar o usuário denunciado
        $user = User::findOne($model->iddenunciado);

        if ($user) {
            // Verificar se o perfil do usuário existe
            if ($user->perfil) {
                // Marcar o usuário como banido no perfil
                $user->perfil->banido = 1;

                // Desativar todos os artigos do usuário
                $artigos = Artigo::find()->where(['idperfil' => $user->id])->all();
                foreach ($artigos as $artigo) {
                    $artigo->ativo = 0;  // Desativar o artigo
                    $artigo->save();  // Salvar as mudanças
                }

                // Salvar as alterações no perfil do usuário
                if ($user->perfil->save()) {
                    Yii::$app->session->setFlash('success', 'User has been banned and all articles have been deactivated.');
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to ban user.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'User profile not found.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'User not found.');
        }

        return $this->redirect(['index']);
    }



}
