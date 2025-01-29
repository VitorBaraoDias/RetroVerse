<?php

namespace frontend\controllers;

use Yii;
use common\models\Seguidor;
use common\models\Perfil;
use common\models\SeguidorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeguidorController implements the CRUD actions for Seguidor model.
 */
class SeguidorController extends Controller
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
                        //'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new SeguidorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['site/index']);
        }

        $model = new Seguidor();

        $idPerfil = Yii::$app->request->post('idperfil');
        $idSeguidor = Yii::$app->user->id;

        if (!Seguidor::find()->where(['idperfil' => $idPerfil, 'idseguidor' => $idSeguidor])->exists()) {
            $model->idperfil = $idPerfil;
            $model->idseguidor = $idSeguidor;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'You are following this user.');
            } else {
                Yii::$app->session->setFlash('error', 'Unable to follow this user.');
            }
        } else {
            Yii::$app->session->setFlash('info', 'You are already following this user.');
        }

        return $this->redirect(['perfil/index', 'id' => $idPerfil]);
    }


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


    public function actionDelete($id)
    {

        $seguidor = Seguidor::findOne(['idperfil' => $id, 'idseguidor' => Yii::$app->user->id]);

        if ($seguidor !== null) {
            $seguidor->delete();
        }

        return $this->redirect(['perfil/index', 'id' => $id]);
    }


    protected function findModel($id)
    {
        if (($model = Seguidor::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
