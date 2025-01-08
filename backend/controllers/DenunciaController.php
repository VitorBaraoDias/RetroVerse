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
use yii\filters\AccessControl;

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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index','view', 'banuser', 'markasresolved'],
                            'allow' => true,
                            'roles' => ['admin', 'moderador'],
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
        );
    }


    public function actionIndex()
    {
        if (Yii::$app->user->can('verDenunciaBackend')) {
        $searchModel = new DenunciaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }

    public function actionView($id)
    {
        if (Yii::$app->user->can('verDetalhesDenunciaBackend')) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]); } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }


    protected function findModel($id)
    {
        if (($model = Denuncia::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMarkasresolved($id)
    {
        if (Yii::$app->user->can('marcarDenunciaResolvidaBackend')) {
        $model = $this->findModel($id);

        if (!$model->estado) {
            $model->estado = 1;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Report marked as resolved.');
            } else {
                Yii::$app->session->setFlash('error', 'Unable to mark report as resolved.');
            }
        } else {
            Yii::$app->session->setFlash('info', 'This report is now marked as resolved.');
        }

        return $this->redirect(['index']);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }

    public function actionBanuser($id)
    {
        if (Yii::$app->user->can('banirMembroBackend')) {
        $model = $this->findModel($id);

        if ($model->estado != 1) {
            $model->estado = 1;
            $model->save();
        }

        $user = User::findOne($model->iddenunciado);

        if ($user) {

            if ($user->perfil) {
                $user->perfil->banido = 1;


                $artigos = Artigo::find()->where(['idperfil' => $user->id])->all();
                foreach ($artigos as $artigo) {
                    $artigo->ativo = 0;
                    $artigo->save();
                }

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
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }



}
