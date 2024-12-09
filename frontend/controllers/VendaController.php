<?php

namespace frontend\controllers;

use common\models\Artigo;
use common\models\Carrinho;
use common\models\Linhavenda;
use common\models\Venda;
use common\models\SearchVenda;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VendaController implements the CRUD actions for Venda model.
 */
class VendaController extends Controller
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
     * Lists all Venda models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchVenda();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Venda model.
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
     * Creates a new Venda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Venda();

        $userId = Yii::$app->user->id;
        $carrinho = Carrinho::findOne(['iduser' => $userId]);
        $this->checkCart($carrinho);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->request->isPost) {
                $model->idcomprador = $userId;
                $model->total = $carrinho->getTotalVenda();

                if ($model->load($this->request->post()) && $model->save()) {
                    $linhasCarrinho = $carrinho->getLinhascarrinhos()->all();
                    foreach ($linhasCarrinho as $linha) {
                        $linhaVenda = new Linhavenda();
                        $linhaVenda->idvenda = $model->id;
                        $linhaVenda->idartigo = $linha->idartigo;
                        $linhaVenda->idvendedor = $linha->artigo->idperfil; // ID do vendedor associado ao artigo

                        if (!$linhaVenda->save()) {
                            throw new \Exception('Erro ao salvar linha de venda: ' . json_encode($linhaVenda->errors));
                        }
                    }
                    // Limpa as linhas do carrinho após salvar as vendas
                    foreach ($linhasCarrinho as $linha) {
                        if (!$linha->delete()) {
                            throw new \Exception('Erro ao eliminar linha do carrinho: ' . json_encode($linha->errors));
                        }
                    }
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Venda criada com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            $model->loadDefaultValues();
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao criar a venda: ' . $e->getMessage());
        }
        // Carrinho e linhas validados, cria o DataProvider
        return $this->render('create', [
            'carrinho' => $carrinho,
            'model' => $model
        ]);
    }


    /**
     * Updates an existing Venda model.
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
     * Deletes an existing Venda model.
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

    /**
     * Finds the Venda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Venda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Venda::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function checkCart($carrinho){

        if ($carrinho === null) {
            Yii::$app->session->setFlash('error', 'Não existe o carrinho.');
            return $this->redirect(['site/index']); // Redireciona para uma página de fallback
        }

        // Verifica se há linhas no carrinho
        if (!$carrinho->getLinhascarrinhos()->exists()) {
            Yii::$app->session->setFlash('info', 'O carrinho está vazio.');
            return $this->redirect(['site/index']); // Redireciona para a página inicial, por exemplo
        }
    }
}