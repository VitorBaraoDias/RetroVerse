<?php

namespace frontend\controllers;

use common\models\LinhasCarrinho;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LinhasCarrinhoController implements the CRUD actions for LinhasCarrinho model.
 */
class LinhascarrinhoController extends Controller
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
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => ['membro'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->response->redirect(['site/login']);
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                       // 'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->can('eliminarLinhacarrinhoFrontend')) {
            $this->findModel($id)->delete();
            $userId = Yii::$app->user->id;

            Yii::$app->session->setFlash('info', 'Item removed from cart!!');

            return $this->redirect(['carrinho/index', 'id' => $userId]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    protected function findModel($id)
    {
        if (($model = LinhasCarrinho::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
