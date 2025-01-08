<?php
namespace frontend\controllers;

use common\models\Clientesplano;
use common\models\Plano;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * ClientesplanoController implements the CRUD actions for Clientesplano model.
 */
class ClientesplanoController extends Controller
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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'create', 'view', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->response->redirect(['site/login']);
                    },
                ],
            ]

        );
    }

    /**
     * Lists all Clientesplano models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Clientesplano::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clientesplano model.
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
     * Creates a new Clientesplano model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($idplano)
    {
        if (\Yii::$app->user->can('criarClientesPlanosFrontend')) {
            $planoAtivo = Plano::findOne($idplano);
            if (!$planoAtivo || !$planoAtivo->ativo) {
                throw new NotFoundHttpException('Plan not found');
            }

            $model = new Clientesplano();

            $existingPlan = Clientesplano::find()
                ->where(['idperfil' => Yii::$app->user->id, 'idplano' => $planoAtivo->id])
                ->exists();

            if ($existingPlan) {
                Yii::$app->session->setFlash('error', 'You already have a Premium plan.');
                return $this->redirect(['plano/index']);
            }

            $model->idperfil = Yii::$app->user->id;
            $model->idplano = $planoAtivo->id;
            $model->setDefaultExpira();

            if ($model->load(Yii::$app->request->post())) {
                Yii::info('Dados carregados: ' . json_encode($model->attributes), __METHOD__);

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Plan added with success.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::info('Erros de validação: ' . json_encode($model->errors), __METHOD__);
                }
            }

            return $this->render('create', [
                'model' => $model,
                'planoAtivo' => $planoAtivo,
            ]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    /**
     * Updates an existing Clientesplano model.
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
     * Deletes an existing Clientesplano model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('eliminarClientesPlanosFrontend')) {

            $this->findModel($id)->delete();

        return $this->redirect(['site/index']);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }

    }

    /**
     * Finds the Clientesplano model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Clientesplano the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clientesplano::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
