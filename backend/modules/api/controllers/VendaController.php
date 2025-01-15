<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Carrinho;
use common\models\Estadoencomenda;
use common\models\Linhavenda;
use common\models\Venda;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `api` module
 */
class VendaController extends ActiveController
{

    public $modelClass = 'common\models\Venda';
    public $user = null;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->request->method !== 'GET' && Yii::$app->request->method !== 'POST' && Yii::$app->request->method !== 'PUT') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'THIS METHOD IS NOT ALLOWED'
            ];
            return false;
        }
        return true;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            'auth' => [$this, 'authCustom'],
        ];
        return $behaviors;
    }

    public function authCustom($token)
    {
        $user_ = \common\models\User::findIdentityByAccessToken($token);
        if($user_) {
            $this->user=$user_;
            return $user_;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication');
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        //proibir get de todas as vendas existentes exceto ao admin
        if ($action === 'index' && $this->user->id != 1) {
            throw new ForbiddenHttpException('You don´t have permission to do this action!');
        }

        if ($this->user) {
            if ($action === 'update' || $action === 'create' || $action === 'view') {
                if ($model) {
                    if ($params['id'] != $this->user->id) {
                        throw new ForbiddenHttpException('You don´t have permission to view this item!');
                    }
                }
            }
        } else {
            throw new ForbiddenHttpException('User not authenticated.');
        }
    }
    public function actionDetalhesvenda($id)
    {
        $venda = Venda::find()
            ->where(['id' => $id])
            ->with('linhavendas.idartigo0')
            ->one();

        $this->checkAccess('view', $venda, ['id' => $venda->idcomprador]);

        if (!$venda) {
            return [
                'status' => 'error',
                'message' => 'Sale not found',
            ];
        }

        $linhasVenda = [];
        foreach ($venda->linhavendas as $linha) {
            $artigo = $linha->idartigo0;


            $fotos = [];
            foreach ($artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }
            $linhasVenda[] = [
                'idvendedor' => $linha->idvendedor,
                'artigo' => [
                    'idartigo' => $linha->idartigo,
                    'nome' => $artigo ? $artigo->nome : null,
                    'preco' => $artigo ? $artigo->precoanuncio : null,
                    'descricao' => $artigo ? $artigo->descricao : null,
                    'marca' => $artigo && $artigo->idmarca0 ? $artigo->idmarca0->nome : null,
                    'tamanho' => $artigo && $artigo->idtamanho0 ? $artigo->idtamanho0->tamanho : null,
                    'categoria' => $artigo && $artigo->idcategoria0 ? $artigo->idcategoria0->nome : null,
                    'tipo' => $artigo ? $artigo->tipoartigo : null,
                    'idperfil' => $artigo ? $artigo->idperfil : null,
                    'fotos' => $fotos,
                ],
            ];
        }

        $detalhes = [
            'idvenda' => $venda->id,
            'total' => $venda->total,
            'datavenda' => $venda->datavenda,
            'idestadoencomenda' => $venda->estadoEncomenda->descricao,
            'idmetodoexpedicao' => $venda->metodoExpedicao->nome,
            'idtipopagamento' => $venda->tipoPagamento->descricao,
            'linhas_venda' => $linhasVenda,
        ];

        return [
            'status' => 'success',
            'detalhesVenda' => $detalhes,
        ];
    }

    public function actionComprar()
    {
        $modelClass = new Venda();
        $request = Yii::$app->request->post();
        $carrinho = Carrinho::findOne(['iduser' => $this->user->id]);

        $this->checkAccess('create', $carrinho, ['id' => $this->user->id]);

        $transaction = Yii::$app->db->beginTransaction();

        if (!$carrinho->ifExistsCart()) {
            throw new \yii\web\ForbiddenHttpException('CART NOT FOUND');
        }

        if ($carrinho->ifExistsCart() && Yii::$app->request->isPost) {
            $modelClass->idcomprador = $this->user->id;
            $modelClass->total = $carrinho->getTotalVenda();
            $modelClass->idestadoencomenda = Estadoencomenda::getIdByStatusCode1();
            $modelClass->idmetodoexpedicao = $request['idmetodoexpedicao'] ?? null;
            $modelClass->idtipopagamento = $request['idtipopagamento'] ?? null;
            $modelClass->nome = $request['nome'] ?? null;
            $modelClass->codigopostal = $request['codigopostal'] ?? null;
            $modelClass->morada = $request['morada'] ?? null;
            $modelClass->pais = $request['pais'] ?? null;
            $modelClass->cidade = $request['cidade'] ?? null;

            if (!$modelClass->save()) {
                throw new \Exception('ERROR: Could not save this purchase. ' . json_encode($modelClass->errors));
            }

            $linhasCarrinho = $carrinho->getLinhascarrinhos()->all();
            $linhasVenda = [];

            foreach ($linhasCarrinho as $linha) {
                $linhaVenda = new Linhavenda();
                $linhaVenda->idvenda = $modelClass->id;
                $linhaVenda->idartigo = $linha->idartigo;
                $linhaVenda->idvendedor = $linha->artigo->idperfil;
                $linhaVenda->idestadoencomenda = Estadoencomenda::getIdByStatusCode1();

                if (!$linhaVenda->save()) {
                    throw new \Exception('ERROR: Could not save this purchase' . json_encode($linhaVenda->errors));
                }


                $artigo = $linhaVenda->idartigo0;
                $fotos = [];
                foreach ($artigo->fotosartigos as $foto) {
                    $fotos[] = $foto->caminhofoto;
                }

                $linhasVenda[] = [
                    'artigo' => [
                        'idartigo' => $linhaVenda->idartigo,
                        'idvendedor' => $linhaVenda->idvendedor,
                        'nome' => $artigo ? $artigo->nome : null,
                        'preco' => $artigo ? $artigo->precoanuncio : null,
                        'descricao' => $artigo ? $artigo->descricao : null,
                        'marca' => $artigo ? $artigo->idmarca0->nome : null,
                        'tamanho' => $artigo ? $artigo->idtamanho0->tamanho : null,
                        'categoria' => $artigo ? $artigo->idcategoria0->nome : null,
                        'tipo' => $artigo ? $artigo->tipoartigo : null,
                        'idperfil' => $artigo ? $artigo->idperfil : null,
                        'fotos' => $fotos,
                        'estadoencomenda' => $linhaVenda->idestadoencomenda0->descricao
                    ],
                ];


                $vendedorPerfil = $linhaVenda->idvendedor0;
                if ($vendedorPerfil) {
                    $vendedorPerfil->saldopendente += $linha->artigo->getPriceFromSoldAcceptedProposal($linhaVenda->idvenda0->idcomprador);
                    if (!$vendedorPerfil->save(false)) {
                        throw new \Exception('ERROR: Could not save pending balance: ' . json_encode($vendedorPerfil->errors));
                    }
                }
            }

            foreach ($linhasCarrinho as $linha) {
                if (!$linha->delete()) {
                    throw new \Exception('ERROR: Could not save this purchase' . json_encode($linha->errors));
                }
            }


            $linhaVenda->idartigo0->ativo = 0;
            $linhaVenda->idartigo0->save();

            $transaction->commit();


            $detalhes = [
                'idvenda' => $modelClass->id,
                'codigo' => $modelClass->codigo ?? null,
                'total' => $modelClass->total,
                'datavenda' => Yii::$app->formatter->asDate(date('Y-m-d H:i:s'), 'php:d/m/Y'),
                'estadoencomenda' => $modelClass->estadoEncomenda->descricao,
                'metodoexpedicao' => $modelClass->metodoExpedicao->nome ?? null,
                'tipopagamento' => $modelClass->tipoPagamento->descricao ?? null,
                'nome' => $modelClass->nome ?? null,
                'codigopostal' => $modelClass->codigopostal ?? null,
                'morada' => $modelClass->morada ?? null,
                'pais' => $modelClass->pais ?? null,
                'cidade' => $modelClass->cidade ?? null,
                'linhasvenda' => $linhasVenda,
            ];

            return [
                $detalhes
            ];
        }
    }


    public function actionHistoricocompras($id)
    {
        $vendas = Venda::find()
            ->where(['idcomprador' => $id])
            ->with('linhavendas.idartigo0')  //
            ->all();

        $this->checkAccess('view', $vendas, ['id' => $id]);

        if (empty($vendas)) {
            return [
                'status' => 'error',
                'message' => 'No purchases found.',
            ];
        }

        $historico = [];
        foreach ($vendas as $venda) {
            $linhasVenda = [];
            foreach ($venda->linhavendas as $linha) {
                $artigo = $linha->idartigo0; //

                $fotos = [];
                foreach ($artigo->fotosartigos as $foto) {
                    $fotos[] = $foto->caminhofoto;
                }
                $linhasVenda[] = [
                    'artigo' =>[
                        'idartigo' => $linha->idartigo,
                        'idvendedor' => $linha->idvendedor,
                        'nome' => $artigo ? $artigo->nome : null,
                        'preco' => $artigo ? $artigo->precoanuncio . '€' : null,
                        'descricao' => $artigo ? $artigo->descricao : null,
                        'marca' => $artigo ? $artigo->idmarca0->nome : null,
                        'tamanho' => $artigo ? $artigo->idtamanho0->tamanho : null,
                        'categoria' => $artigo ? $artigo->idcategoria0->nome: null,
                        'tipo' => $artigo ? $artigo->tipoartigo : null,
                        'idperfil' => $artigo ? $artigo->idperfil : null,
                        'fotos' => $fotos,
                    ],
                    'estadoencomenda' => $linha->idestadoencomenda0->descricao
                ];
            }

            $historico[] = [
                'idvenda' => $venda->id,
                'total' => $venda->total,
                'datavenda' => $venda->datavenda,
                'estadoencomenda' => $venda->estadoEncomenda->descricao,
                'idmetodoexpedicao' => $venda->metodoExpedicao->nome,
                'idtipopagamento' => $venda->tipoPagamento->descricao,
                'linhas_venda' => $linhasVenda,
            ];
        }
        return [
            'status' => 'success',
            'historicocompras' => $historico,
        ];
    }

    public function actionHistoricovendas($id)
    {
        $linhasVenda = Linhavenda::find()
            ->where(['idvendedor' => $id])
            ->with(['idvenda0', 'idartigo0.idmarca0', 'idartigo0.idtamanho0', 'idartigo0.idcategoria0'])
            ->all();

        $this->checkAccess('view', $linhasVenda, ['id' => $id]);

        if (empty($linhasVenda)) {
            return [
                'status' => 'error',
                'message' => 'No sales found for this user.',
            ];
        }

        $historico = [];
        foreach ($linhasVenda as $linha) {
            $artigo = $linha->idartigo0;
            $venda = $linha->idvenda0;
            $fotos = [];
            foreach ($artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }
            $historico[] = [
                'linhavenda' => [
                    'idvenda' => $linha->idvenda,
                    'idlinhavenda' => $linha->id,
                    'datavenda' => $venda ? $venda->datavenda : null,
                    'idestadoencomenda' => $linha->idestadoencomenda,
                    'artigo' =>[
                        'idartigo' => $linha->idartigo,
                        'nome' => $artigo ? $artigo->nome : null,
                        'descricao' => $artigo ? $artigo->descricao : null,
                        'marca' => $artigo && $artigo->idmarca0 ? $artigo->idmarca0->nome : null,
                        'tamanho' => $artigo && $artigo->idtamanho0 ? $artigo->idtamanho0->tamanho : null,
                        'categoria' => $artigo && $artigo->idcategoria0 ? $artigo->idcategoria0->nome : null,
                        'tipo' => $artigo ? $artigo->tipoartigo : null,
                        'fotos' => $fotos,

                    ]
                ]];
        }

        return [
            'status' => 'success',
            'historicovendas' => $historico,
        ];

    }
}
