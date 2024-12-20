<?php

namespace frontend\controllers;

use Yii;
use common\models\Linhavenda;
use common\models\Estadoencomenda;
use common\models\LinhavendaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $searchModel = new LinhavendaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Linhavenda model.
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
     * Creates a new Linhavenda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
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
    }

    /**
     * Updates an existing Linhavenda model.
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
     * Deletes an existing Linhavenda model.
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


    public function actionOrdersent($id)
    {
        $linhaVenda = LinhaVenda::findOne($id); // Substitua LinhaVenda pelo modelo correto da tabela
        if ($linhaVenda === null) {
            throw new NotFoundHttpException('Item not found.');
        }

        // Obter o último estado da tabela estadoEncomenda
        $ultimoEstado = EstadoEncomenda::find()->orderBy(['id' => SORT_DESC])->one();
        if ($ultimoEstado === null) {
            throw new \Exception('No states found in EstadoEncomenda.');
        }

        // Atualizar o estado da encomenda para o último estado
        $linhaVenda->idestadoencomenda = $ultimoEstado->id;

        if ($linhaVenda->save()) {
            Yii::$app->session->setFlash('success', 'Item marked as sent successfully.');
            $linhaVenda->idvenda0->checkAndSetFinalState();
        } else {
            Yii::$app->session->setFlash('error', 'Failed to update item status.');
        }

        return $this->redirect(['venda/index?VendaSearch%5BtipoVenda%5D=sales']); // Redirecione para a página desejada
    }

    /**
     * Finds the Linhavenda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Linhavenda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Linhavenda::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
