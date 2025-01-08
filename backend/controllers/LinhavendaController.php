<?php

namespace backend\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use common\models\Linhavenda;
use common\models\Estadoencomenda;
use common\models\LinhavendaSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * LinhavendaController implements the CRUD actions for Linhavenda model.
 */
class LinhavendaController extends Controller
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
                            'actions' => ['index','ordersent', 'report'],
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
        );
    }

    /**
     * Lists all Linhavenda models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('verEncomendasLojaBackend')) {
            $searchModel = new LinhavendaSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }  else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }
    }


    public function actionReport()
    {
        if (Yii::$app->user->can('gerarReportEncomendasLojaBackend')) {
            $month = Yii::$app->request->get('month');

            if (!$month) {
                $month = date('m');
            }

            if (Yii::$app->user->can('admin')) {
                $dataProvider = new ActiveDataProvider([
                    'query' => Linhavenda::find()
                        ->joinWith('idvenda0 as venda')
                        ->where(['MONTH(DATE(venda.datavenda))' => $month])
                        ->andWhere(['idvendedor' => Yii::$app->user->id]),
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);
            } else {
                return $this->render('index');
            }

            return $this->render('report', [
                'dataProvider' => $dataProvider,
                'month' => $month,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
        }

    }


    public function actionOrdersent($id)
    {
        if (Yii::$app->user->can('confirmarEnvioEncomendasLojaBackend')) {
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

            return $this->redirect(['linhavenda/index']);
        } else {
            throw new \yii\web\ForbiddenHttpException('You do not have permission to access this resource.');
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