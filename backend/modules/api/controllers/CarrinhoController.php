<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\Carrinho;
use yii\filters\auth\QueryParamAuth;
use Yii;
use common\models\Linhascarrinho;


/**
 * Default controller for the `api` module
 */
class CarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\Carrinho';


    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create']);

        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionUser($id)
    {
        // Busca o carrinho do usuário pelo ID
        $carrinho = Carrinho::find()->where(['iduser' => $id])->one();

        if (!$carrinho) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Nenhum carrinho encontrado para o utilizador fornecido.',
            ];
        }

        // Agora utiliza o ID do carrinho encontrado para consultar as linhas associadas
        $linhasCarrinho = Linhascarrinho::find()
            ->with([
                'artigo',        // Carrega a relação com o artigo
                'artigo.idcomissao0', // Carrega a comissão associada ao artigo
                'artigo.idestado0', // Carrega o estado do artigo
                'artigo.idmarca0', // Carrega a marca do artigo
                'artigo.idcategoria0', // Carrega a categoria do artigo
                'artigo.idtamanho0', // Carrega o tamanho do artigo
                'artigo.idperfil0', // Carrega o perfil associado ao artigo
            ])
            ->where(['idcarrinho' => $carrinho->id]) // Usando $carrinho->id
            ->all();

        // Verifica se as linhas foram encontradas
        if (!$linhasCarrinho) {
            return [
                'success' => true,
                'carrinho' => [],
                'message' => 'Nenhuma linha encontrada para este carrinho.',
            ];
        }

        $linhasCarrinhoFormatted = [];

        foreach ($linhasCarrinho as $linha) {
            $artigo = $linha->artigo;

            $linhasCarrinhoFormatted[] = [
                'id' => $linha->id,
                'idcarrinho' => $linha->idcarrinho,
                'idartigo' => $linha->idartigo,
                'artigo' => $artigo ? [
                    'nome' => $artigo->nome,
                    'descricao' => $artigo->descricao,
                    'precoanuncio' => $artigo->precoanuncio,
                    'comissao' => $artigo->idcomissao0->comissao,
                    'estado' => $artigo->idestado0->descricao,
                    'marca' => $artigo->idmarca0->nome,
                    'categoria' => $artigo->idcategoria0->nome,
                    'tamanho' => $artigo->idtamanho0->tamanho,
                    'perfil' => "@" . $artigo->idperfil0->username,
                    'tipoartigo' => $artigo->tipoartigo,
                ] : null,
            ];
        }

        return [
            'success' => true,
            'carrinho' => $linhasCarrinhoFormatted,
        ];
    }
    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->request->method !== 'POST' && Yii::$app->request->method !== 'GET') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'success' => false,
                'message' => 'Este método não é permitido.',
            ];
            return false;
        }

        return true;
    }

    public function actionDetalhes()
    {
        // Busca todos os carrinhos
        $carrinhos = Carrinho::find()->all();

        $carrinhosFormatted = [];

        foreach ($carrinhos as $carrinho) {
            $linhasCarrinho = Linhascarrinho::find()
                ->with([
                    'artigo',
                    'artigo.idcomissao0',
                    'artigo.idestado0',
                    'artigo.idmarca0',
                    'artigo.idcategoria0',
                    'artigo.idtamanho0',
                    'artigo.idperfil0',
                ])
                ->where(['idcarrinho' => $carrinho->id]) // Relaciona as linhas ao carrinho
                ->all();

            // Verifica se as linhas foram encontradas
            if (!$linhasCarrinho) {
                $carrinhosFormatted[] = [
                    'id' => $carrinho->id,
                    'iduser' => $carrinho->iduser,
                    'message' => 'Nenhuma linha encontrada para este carrinho.',
                ];
                continue;  // Vai para o próximo carrinho
            }

            $linhasCarrinhoFormatted = [];

            foreach ($linhasCarrinho as $linha) {
                $artigo = $linha->artigo;
                $fotos = [];
                foreach ($artigo->fotosartigos as $foto) {
                    $fotos[] = $foto->caminhofoto;

                    $linhasCarrinhoFormatted[] = [
                        'id' => $linha->id,
                        'idcarrinho' => $linha->idcarrinho,
                        'idartigo' => $linha->idartigo,
                        'artigo' => $artigo ? [
                            'nome' => $artigo->nome,
                            'descricao' => $artigo->descricao,
                            'precoanuncio' => $artigo->precoanuncio,
                            'comissao' => $artigo->idcomissao0->comissao,
                            'estado' => $artigo->idestado0->descricao,
                            'marca' => $artigo->idmarca0->nome,
                            'categoria' => $artigo->idcategoria0->nome,
                            'tamanho' => $artigo->idtamanho0->tamanho,
                            'perfil' => "@" . $artigo->idperfil0->username,
                            'tipoartigo' => $artigo->tipoartigo,
                            'fotos' => $fotos,  // Adicionando as fotos ao resultado

                        ] : null,
                    ];
                }
            }

            // Adiciona o carrinho com as linhas formatadas
            $carrinhosFormatted[] = [
                'id' => $carrinho->id,
                'iduser' => $carrinho->iduser,
                'linhas_carrinho' => $linhasCarrinhoFormatted,
            ];
        }

        return [
            'success' => true,
            'carrinhos' => $carrinhosFormatted,
        ];
    }

    public function actionCreate()
    {
        $request = Yii::$app->request->post();

        // Valida se o carrinho está presente no corpo da requisição
        if (empty($request['carrinho'])) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Os dados do carrinho são obrigatórios.',
            ];
        }

        // Criação do Carrinho
        $carrinho = new Carrinho();
        $carrinho->iduser = $request['iduser'];
        $carrinho->datacriacao = date('Y-m-d H:i:s');

        if (!$carrinho->save()) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Erro ao criar o carrinho.',
                'errors' => $carrinho->errors,
            ];
        }

        $linhasCarrinhoErrors = []; // Para coletar erros nas linhas

        // Processa as linhas do carrinho enviadas
        foreach ($request['carrinho'] as $linhaData) {
            $linhaCarrinho = new Linhascarrinho();
            $linhaCarrinho->idcarrinho = $carrinho->id;
            $linhaCarrinho->idartigo = $linhaData['idartigo'];

            // Tenta salvar a linha
            if (!$linhaCarrinho->save()) {
                $linhasCarrinhoErrors[] = [
                    'linha' => $linhaData,
                    'errors' => $linhaCarrinho->errors,
                ];
            }
        }

        // Verifica se houve erros nas linhas do carrinho
        if (!empty($linhasCarrinhoErrors)) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Erro ao salvar uma ou mais linhas do carrinho.',
                'details' => $linhasCarrinhoErrors,
            ];
        }

        return [
            'success' => true,
            'message' => 'Carrinho criado com sucesso!',
            'data' => [
                'idcarrinho' => $carrinho->id,
                'iduser' => $carrinho->iduser,
            ],
        ];
    }


}
