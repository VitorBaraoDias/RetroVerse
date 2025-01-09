<?php

namespace backend\modules\api\controllers;

use common\models\Carrinho;
use common\models\User;
use common\models\Linhascarrinho;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use backend\modules\api\components\CustomAuth;


/**
 * Default controller for the `api` module
 */
class CarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\Carrinho';
    public $user = null;


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            'auth' => [$this, 'authCustom'],
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
        if ($this->user) {
            if ($action === 'create' || $action === 'view') {
                if ($model && $model->iduser != $this->user->id) {
                    throw new \yii\web\ForbiddenHttpException('You don´t have permission to do this action!');
                }
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('User not authenticated.');
        }
    }

    public function actionUser()
    {
        if (!$this->user) {
            Yii::$app->response->statusCode = 401;
            return [
                'success' => false,
                'message' => 'Invalid authorization token.',
            ];
        }

        $carrinho = Carrinho::find()->where(['iduser' => $this->user->id])->one();
        if (!$carrinho) {
            $carrinho = new Carrinho();
            $carrinho->iduser = $user->id;
            if (!$carrinho->save()) {
                Yii::$app->response->statusCode = 500;
                return [
                    'success' => false,
                    'message' => 'Failed to create a cart for the user.',
                    'errors' => $carrinho->getErrors(),
                ];
            }
        }

        $this->checkAccess('view', $carrinho);

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
            ->where(['idcarrinho' => $carrinho->id])
            ->all();

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

    public function actionCreatecarrinho()
    {
        $request = Yii::$app->request->post();
        $carrinho = Carrinho::findOne(['iduser' => $this->user->id]) ?? new Carrinho(['iduser' => $this->user->id]);

        $this->checkAccess('create', $carrinho);


        if ($carrinho->isNewRecord && !$carrinho->save()) {
            throw new \yii\web\ForbiddenHttpException('Failed to create a cart');
        }

        if (Linhascarrinho::findOne(['idcarrinho' => $carrinho->id, 'idartigo' => $request['idartigo']])) {
            throw new \yii\web\ForbiddenHttpException('This item is already in the cart for this user.');
        } else {
            $linhaCarrinho = new Linhascarrinho(['idcarrinho' => $carrinho->id, 'idartigo' => $request['idartigo']]);
            $linhaCarrinho->save();
        }

        //todas as linhas ja existentes no cart do user
        $linhasCarrinho = Linhascarrinho::find()
            ->with(['artigo', 'artigo.idcomissao0', 'artigo.idestado0', 'artigo.idmarca0', 'artigo.idcategoria0', 'artigo.idtamanho0', 'artigo.idperfil0'])
            ->where(['idcarrinho' => $carrinho->id])
            ->all();

        $result = [];
        foreach ($linhasCarrinho as $linha) {
            $artigo = $linha->artigo;

            //fotos do artigo
            $fotos = [];
            foreach ($artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }


            $isPremium = (bool)\common\models\Artigospremium::find()
                ->where(['id' => $artigo->id])
                ->exists();


            $isLiked = (bool)\common\models\Favorito::find()
                ->where(['idartigo' => $artigo->id, 'idperfil' => $this->user->id])
                ->exists();


            $result[] = [
                'id' => $artigo->id,
                'datacriacao' => Yii::$app->formatter->asDate($artigo->datacriacao, 'dd/MM/yyyy'),
                'nome' => $artigo->nome,
                'descricao' => $artigo->descricao,
                'precoanuncio' => $artigo->precoanuncio,
                'comissao' => $artigo->idcomissao0 ? $artigo->idcomissao0->comissao : null,
                'estado' => $artigo->idestado0 ? $artigo->idestado0->descricao : null,
                'marca' => $artigo->idmarca0 ? $artigo->idmarca0->nome : null,
                'categoria' => $artigo->idcategoria0 ? $artigo->idcategoria0->nome : null,
                'tamanho' => $artigo->idtamanho0 ? $artigo->idtamanho0->tamanho : null,
                'tipoartigo' => $artigo->tipoartigo,
                'fotos' => $fotos,
                'perfil' => $artigo->idperfil0 ? [
                    'id' => $artigo->idperfil0->id,
                    'descricao' => $artigo->idperfil0->descricao,
                    'caminhofotoperfil' => $artigo->idperfil0->caminhofotoperfil,
                    'morada' => $artigo->idperfil0->morada,
                ] : null,
                'premium' => $isPremium,
                'isLiked' => $isLiked,
            ];
        }

        return [
            'id' => $carrinho->id,
            'iduser' => $carrinho->iduser,
            'linhascarrinho' => $result,
        ];
    }

}
