<?php

namespace frontend\controllers;

use common\models\Carrinho;
use common\models\Estadoencomenda;
use common\models\Linhavenda;
use common\models\LinhavendaSearch;
use common\models\Venda;
use common\models\VendaSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        $queryParams = Yii::$app->request->queryParams;

        $tipoVenda = $queryParams['VendaSearch']['tipoVenda'] ?? 'purchases';
        $statusFilter = $queryParams['status'] ?? null;

        if ($tipoVenda === 'sales') {
            $searchModel = new LinhaVendaSearch();
            $queryParams['LinhavendaSearch']['statusFilter'] = $statusFilter; // Filtro para sales
            $viewType = 'sales'; // Parcial para vendas
        } else {
            $searchModel = new VendaSearch();
            $queryParams['VendaSearch']['statusFilter'] = $statusFilter; // Filtro para purchases
            $viewType = 'purchases'; // Parcial para compras
        }

        $dataProvider = $searchModel->search($queryParams);

        return $this->render( 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'viewType' => $viewType,
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
        $model = $this->findModel($id);

        // Criação do dataProvider para listar as linhas de venda associadas à venda atual
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getLinhavendas(),  // Método que traz as Linhavendas associadas à venda
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,  // Passa o dataProvider para a view
        ]);
    }

    public function actionViewinvoice($id)
    {
        $model = $this->findModel($id);

        // Criação do dataProvider para listar as linhas de venda associadas à venda atual
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getLinhavendas(),  // Método que traz as Linhavendas associadas à venda
        ]);

        return $this->render('viewinvoice', [
            'model' => $model,
            'dataProvider' => $dataProvider,  // Passa o dataProvider para a view
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
        $transaction = Yii::$app->db->beginTransaction();

        if(!$carrinho->ifExistsCart()){
            Yii::$app->session->setFlash('error', 'Não existe o carrinho');
            return $this->redirect(['site/index']);
        }
        try {
            if ($carrinho->ifExistsCart() && $this->request->isPost) {
                $model->idcomprador = $userId;
                $model->total = $carrinho->getTotalVenda();
                $model->idestadoencomenda = Estadoencomenda::getIdByStatusCode1(); //vai buscar o id do do status 1


                if ($model->load($this->request->post()) && $model->save()) {
                    $linhasCarrinho = $carrinho->getLinhascarrinhos()->all();
                    foreach ($linhasCarrinho as $linha) {
                        $linhaVenda = new Linhavenda();
                        $linhaVenda->idvenda = $model->id;
                        $linhaVenda->idartigo = $linha->idartigo;
                        $linhaVenda->idvendedor = $linha->artigo->idperfil;
                        $linhaVenda->idestadoencomenda = Estadoencomenda::getIdByStatusCode1();

                        if (!$linhaVenda->save()) {
                            throw new \Exception('Erro ao salvar linha de venda: ' . json_encode($linhaVenda->errors));
                        }

                        // Atualiza o saldo pendente do vendedor
                        $vendedorPerfil = $linhaVenda->idvendedor0; // Obtém o perfil do vendedor
                        if ($vendedorPerfil) {
                            $vendedorPerfil->saldopendente += $linha->artigo->getPriceFromSoldAcceptedProposal($linhaVenda->idvenda0->idcomprador); // Adiciona o valor da linha ao saldo pendente
                            if (!$vendedorPerfil->save(false)) {
                                throw new \Exception('Erro ao atualizar saldo pendente: ' . json_encode($vendedorPerfil->errors));
                            }
                        }
                    }

                    // Limpa as linhas do carrinho após salvar as vendas
                    foreach ($linhasCarrinho as $linha) {
                        if (!$linha->delete()) {
                            throw new \Exception('Erro ao eliminar linha do carrinho: ' . json_encode($linha->errors));
                        }
                    }

                    //
                    $linhaVenda->idartigo0->ativo = 0;
                    $linhaVenda->idartigo0->save();
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Venda criada com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            $model->loadDefaultValues();
        } catch (\Exception $e) {
            Yii::error('Erro ao criar a venda: ' . $e->getMessage() . "\n" . $e->getTraceAsString(), __METHOD__);
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Ocorreu um erro ao criar a venda: ' . $e->getMessage());
        }
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


}