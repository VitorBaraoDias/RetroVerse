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
                'message' => 'Nenhum carrinho encontrado para o usuário fornecido.',
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

}
