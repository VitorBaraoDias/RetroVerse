<?php

namespace backend\controllers;


use Yii;
use common\models\Artigospremium;
use common\models\Plano;
use common\models\Artigo;
use app\models\SearchArtigopremium;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * ArtigospremiumController implements the CRUD actions for Artigospremium model.
 */
class ArtigospremiumController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                [
                    'access' => [
                        'class' => AccessControl::class,
                        'rules' => [
                            [
                                'actions' => ['create','delete'],
                                'allow' => true,
                                'roles' => ['admin'],
                            ],
                        ],
                        'denyCallback' => function ($rule, $action) {
                            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this page.');
                        },
                    ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                    ]
                ]
        );
    }



    public function actionCreate($id)
    {
        if (Yii::$app->user->can('criarArtigoPremiumBackend')) {
        $model = new Artigospremium();

        $planos = Plano::find()->all();


        $artigo = Artigo::findOne($id);
        if (!$artigo) {

            Yii::$app->session->setFlash('error', 'Item not found.');
            return $this->redirect(['artigo/index']);
        }


        $planoAtivo = Plano::find()->where(['ativo' => 1])->one();
        if (!$planoAtivo) {
            Yii::$app->session->setFlash('error', 'No plan found.');
            return $this->redirect(['artigo/index']);
        }


        $model = new Artigospremium();
        $model->id = $id;
        $model->idPlano = $planoAtivo->id;

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Plan added with success.');
        } else {
            Yii::$app->session->setFlash('error', 'Error. Could not complete this process.');
        }

        return $this->redirect(['artigo/index']);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }


    public function actionDelete($id)
    {
        if (Yii::$app->user->can('eliminarArtigoPremiumBackend')) {
        $this->findModel($id)->delete();

        return $this->redirect(['artigo/index']);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }


    protected function findModel($id)
    {
        if (($model = Artigospremium::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
