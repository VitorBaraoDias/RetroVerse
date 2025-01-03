<?php

namespace backend\modules\api\controllers;

use common\models\Carrinho;
use common\models\Linhascarrinho;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


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
    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->request->method !== 'POST' && Yii::$app->request->method !== 'GET') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'success' => false,
                'message' => 'METHOD NOT ALLOWED.',
            ];
            return false;
        }

        return true;
    }

    public function actionUser($id)
    {
        // Busca o carrinho do usuário pelo ID
        $carrinho = Carrinho::find()->where(['iduser' => $id])->one();

        if (!$carrinho) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Could not find a cart for this user.',
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
                'message' => 'No item found in this cart.',
            ];
        }

        $linhasCarrinhoFormatted = [];

        foreach ($linhasCarrinho as $linha) {
            $artigo = $linha->artigo;

            $fotos = [];
            foreach ($artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }
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
                    'username' =>  $artigo->idperfil0->user->username,
                    'tipoartigo' => $artigo->tipoartigo,
                    'fotos' => $fotos,

                ] : null,
            ];
        }

        return [
            'success' => true,
            'carrinho' => $linhasCarrinhoFormatted,
        ];
    }

    public function actionCreate()
    {
        $request = Yii::$app->request->post();
        $carrinho = Carrinho::findOne(['iduser' => $request['iduser']]) ?? new Carrinho(['iduser' => $request['iduser']]);

        if ($carrinho->isNewRecord && !$carrinho->save()) {
            throw new \yii\web\ForbiddenHttpException('Failed to create a cart');
        }

        if (Linhascarrinho::findOne(['idcarrinho' => $carrinho->id, 'idartigo' => $request['idartigo']])) {
            throw new \yii\web\ForbiddenHttpException('This item is already in the cart for this user.');
        } else {
            $linhaCarrinho = new Linhascarrinho(['idcarrinho' => $carrinho->id, 'idartigo' => $request['idartigo']]);
            $linhaCarrinho->save();
        }
        return [
            'status' => 'success',
            'message' => 'Cart created!',
        ];
    }



}
