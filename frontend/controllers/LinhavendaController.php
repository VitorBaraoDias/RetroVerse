<?php

namespace frontend\controllers;

use common\models\Estadoencomenda;
use common\models\Linhavenda;
use common\models\LinhavendaSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class LinhavendaController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'create', 'ordersent', 'orderreceived'],
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
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionIndex()
    {
        if (Yii::$app->user->can('verLinhavendaFrontend')) {
            $searchModel = new LinhavendaSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    public function actionCreate()
    {
        if (Yii::$app->user->can('criarLinhavendaFrontend')) {
            $model = new Linhavenda();

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
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    public function actionOrdersent($id)
    {
        if (Yii::$app->user->can('confirmarEnvioEncomendaFrontend')) {
            $linhaVenda = LinhaVenda::findOne($id);
            if ($linhaVenda === null) {
                throw new NotFoundHttpException('Item not found.');
            }


            $estadoAtual = $linhaVenda->idestadoencomenda0;


            $proximoEstado = EstadoEncomenda::find()
                ->where(['>', 'id', $estadoAtual->id])
                ->orderBy(['id' => SORT_ASC])
                ->one();

            if ($proximoEstado === null) {
                Yii::$app->session->setFlash('warning', 'This item is already in the final state.');
                return $this->redirect(['venda/index?VendaSearch%5BtipoVenda%5D=sales']);
            }


            $linhaVenda->idestadoencomenda = $proximoEstado->id;

            if ($linhaVenda->save()) {
                Yii::$app->session->setFlash('success', 'Item state updated to the next state successfully.');

                $linhaVenda->idvenda0->checkAndSetNextState();
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update item state.');
            }

            return $this->redirect(['venda/index?VendaSearch%5BtipoVenda%5D=sales']);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    public function actionOrderreceived($id)
    {
        if (Yii::$app->user->can('confirmarRecebimentoEncomendaFrontend')) {
            $linhaVenda = Linhavenda::findOne($id);

            if (!$linhaVenda) {
                Yii::$app->session->setFlash('error', 'Sales line not found.');
                return $this->redirect(['venda/view', 'id' => $linhaVenda->idvenda]);
            }


            $estadoFinal = Estadoencomenda::find()->orderBy(['status' => SORT_DESC])->one();

            if (!$estadoFinal) {
                Yii::$app->session->setFlash('error', 'End state not found.');
                return $this->redirect(['venda/view', 'id' => $linhaVenda->idvenda]);
            }


            $linhaVenda->idestadoencomenda = $estadoFinal->id;

            if ($linhaVenda->save()) {
                Yii::$app->session->setFlash('success', 'Sales line marked as received.');
                return $this->redirect(['venda/view', 'id' => $linhaVenda->idvenda]);
            } else {
                Yii::$app->session->setFlash('error', 'Error updating the sales line status.');
                return $this->redirect(['venda/view', 'id' => $linhaVenda->idvenda]);
            }
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    protected function findModel($id)
    {
        if (($model = Linhavenda::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
