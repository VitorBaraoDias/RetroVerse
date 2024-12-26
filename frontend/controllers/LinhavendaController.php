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
        $linhaVenda = LinhaVenda::findOne($id);
        if ($linhaVenda === null) {
            throw new NotFoundHttpException('Item not found.');
        }

        // Obter o estado atual da linha de venda
        $estadoAtual = $linhaVenda->idestadoencomenda0;

        // Encontrar o próximo estado baseado na ordem
        $proximoEstado = EstadoEncomenda::find()
            ->where(['>', 'id', $estadoAtual->id]) // Buscar estado seguinte
            ->orderBy(['id' => SORT_ASC]) // Buscar o próximo estado em ordem crescente
            ->one();

        if ($proximoEstado === null) {
            Yii::$app->session->setFlash('warning', 'This item is already in the final state.');
            return $this->redirect(['venda/index?VendaSearch%5BtipoVenda%5D=sales']); // Redirecionar sem alterações
        }

        // Atualizar o estado da linha de venda para o próximo estado
        $linhaVenda->idestadoencomenda = $proximoEstado->id;

        if ($linhaVenda->save()) {
            Yii::$app->session->setFlash('success', 'Item state updated to the next state successfully.');

            // Verificar e atualizar o estado da venda, se necessário
            $linhaVenda->idvenda0->checkAndSetNextState();
        } else {
            Yii::$app->session->setFlash('error', 'Failed to update item state.');
        }

        return $this->redirect(['venda/index?VendaSearch%5BtipoVenda%5D=sales']); // Redirecione para a página desejada
    }


    public function actionOrderreceived($id)
    {
        // Obtém a linha de venda correspondente
        $linhaVenda = Linhavenda::findOne($id);

        if (!$linhaVenda) {
            Yii::$app->session->setFlash('error', 'Linha de venda não encontrada.');
            return $this->redirect(['venda/view', 'id' => $linhaVenda->idvenda]);
        }

        // Obtém o estado final
        $estadoFinal = Estadoencomenda::find()->orderBy(['status' => SORT_DESC])->one();

        if (!$estadoFinal) {
            Yii::$app->session->setFlash('error', 'Estado final não encontrado.');
            return $this->redirect(['venda/view', 'id' => $linhaVenda->idvenda]);
        }

        // Atualiza o estado da linha de venda para o estado final
        $linhaVenda->idestadoencomenda = $estadoFinal->id;

        if ($linhaVenda->save()) {
            Yii::$app->session->setFlash('success', 'Linha de venda marcada como recebida.');
            return $this->redirect(['venda/view', 'id' => $linhaVenda->idvenda]);
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao atualizar o estado da linha de venda.');
            return $this->redirect(['venda/view', 'id' => $linhaVenda->idvenda]);
        }

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
