<?php

namespace frontend\controllers;

use common\models\Artigo;
use common\models\Denuncia;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                        return Yii::$app->response->redirect(['site/index']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
            ],
        ];
    }

    /**
     * Creates a new Denuncia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        if (\Yii::$app->user->can('CriarDenunciaFrontend')) {

            $model = new Denuncia();
            $artigo = Artigo::findOne($id);
            $userId = Yii::$app->user->id; // ID do usuário logado

            $jaDenunciado = Denuncia::find()
                ->where(['iddenunciante' => $userId, 'idartigo' => $artigo->id])
                ->exists();

            if (Denuncia::hasAlreadyReported($userId, $artigo->id)) {
                Yii::$app->session->setFlash('error', 'You have already reported this article.');
                return $this->redirect(['artigo/view-marketplace', 'id' => $artigo->id]);
            }

            if ($this->request->isPost) {
                $model->iddenunciante = $userId; // ID do usuário logado
                $model->iddenunciado = $artigo->idperfil;
                $model->idartigo = $artigo->id;
                if ($model->load($this->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Report successfully created.');
                    return $this->redirect(['artigo/view-marketplace', 'id' => $artigo->id]);
                }
            } else {
                $model->loadDefaultValues();
            }
            return $this->render('create', [
                'model' => $model,
                'artigo' => $artigo,
            ]);
        }
        else {
            return Yii::$app->response->redirect(['site/login']);
        }
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
}
