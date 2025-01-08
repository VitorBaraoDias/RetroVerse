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
use yii\filters\AccessControl;
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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'viewinvoice', 'create'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->response->redirect(['site/index']);
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
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
        if (\Yii::$app->user->can('verVendasFrontend')) {

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

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'viewType' => $viewType,
            ]);
        }
        else{
            return Yii::$app->response->redirect(['site/index']);
        }
    }

    /**
     * Displays a single Venda model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('verDetalhesVendaFrontend')) {

            $model = $this->findModel($id);
            $dataProvider = new ActiveDataProvider([
                'query' => $model->getLinhavendas(),
            ]);

            return $this->render('view', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
            return Yii::$app->response->redirect(['site/index']);
        }
    }

    public function actionViewinvoice($id)
    {
        if (\Yii::$app->user->can('verFaturaVendaFrontend')) {

            $model = $this->findModel($id);


            $dataProvider = new ActiveDataProvider([
                'query' => $model->getLinhavendas(),
            ]);

            return $this->render('viewinvoice', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return Yii::$app->response->redirect(['site/index']);
        }
    }

    /**
     * Creates a new Venda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('verFaturaVendaFrontend')) {

            $model = new Venda();

            $userId = Yii::$app->user->id;
            $carrinho = Carrinho::findOne(['iduser' => $userId]);
            $transaction = Yii::$app->db->beginTransaction();

            if (!$carrinho->ifExistsCart()) {
                Yii::$app->session->setFlash('error', 'Não existe o carrinho');
                return $this->redirect(['site/index']);
            }
            try {
                if ($carrinho->ifExistsCart() && $this->request->isPost) {
                    $model->idcomprador = $userId;
                    $model->total = $carrinho->getTotalVenda();
                    $model->idestadoencomenda = Estadoencomenda::getIdByStatusCode1();


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


                            $vendedorPerfil = $linhaVenda->idvendedor0;
                            if ($vendedorPerfil) {
                                $vendedorPerfil->saldopendente += $linha->artigo->getPriceFromSoldAcceptedProposal($linhaVenda->idvenda0->idcomprador); // Adiciona o valor da linha ao saldo pendente
                                if (!$vendedorPerfil->save(false)) {
                                    throw new \Exception('Erro ao atualizar saldo pendente: ' . json_encode($vendedorPerfil->errors));
                                }
                            }
                        }


                        foreach ($linhasCarrinho as $linha) {
                            if (!$linha->delete()) {
                                throw new \Exception('Erro ao eliminar linha do carrinho: ' . json_encode($linha->errors));
                            }
                        }

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
        else{
            return Yii::$app->response->redirect(['site/login']);
        }
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