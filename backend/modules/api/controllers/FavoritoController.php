<?php
namespace backend\modules\api\controllers;

use common\models\Favorito;
use common\models\Artigo;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use backend\modules\api\components\CustomAuth;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `api` module
 */
class FavoritoController extends ActiveController
{
    public $modelClass = 'common\models\Favorito';
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

    public function authCustom($token)
    {

        $user_ = Yii::$app->user->identity->findIdentityByAccessToken($token);

        if ($user_) {
            $this->user = $user_;
            return $user_;
        }


        throw new \yii\web\ForbiddenHttpException('No authentication');
    }

    public function checkAccess($action, $model = null, $params = [])
    {

        if ($this->user) {
            //proibir get de todos os favs exceto ao admin
            if ($action === 'index' && $this->user->id != 1) {
                    throw new ForbiddenHttpException('You don´t have permission to do this action!');
            }

            if ($action === 'view' && $params ['id'] != $this->user->id) {
                throw new ForbiddenHttpException('You don´t have permission to do this action!');
            }

            if (($action === 'create' ||  $action === 'delete') && $model->idperfil !== $this->user->id) {
                throw new ForbiddenHttpException('You do not have permission to do this action!');
            }

        } else {
            throw new ForbiddenHttpException('User not authenticated.');
        }
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->request->method !== 'GET' && Yii::$app->request->method !== 'POST' && Yii::$app->request->method !== 'DELETE') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'THIS METHOD IS NOT ALLOWED!'
            ];
            return false;
        }
        return true;
    }

    public function actionCreatefavorito()
    {
        if (!$this->user) {
            throw new ForbiddenHttpException('User not authenticated.');
        }

        $request = Yii::$app->request;
        $idartigo = $request->post('idartigo');
        $idperfil =$request->post('idperfil');

        if (!$idartigo) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Item ID is required.',
            ];
        }

        // Check if the article exists
        $artigo = Artigo::findOne($idartigo);
        if (!$artigo) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Item not found.',
            ];
        }

        // Check if the user is trying to favorite their own article
        if ($artigo->idperfil == $idperfil) {
            Yii::$app->response->statusCode = 403;
            return [
                'success' => false,
                'message' => 'You cannot add your own item to favorites.',
            ];
        }

        // Check if the article is already in the user's favorites
        $existingFavorito = Favorito::find()
            ->where(['idperfil' => $idperfil, 'idartigo' => $idartigo])
            ->one();

        if ($existingFavorito) {
            Yii::$app->response->statusCode = 409;
            return [
                'success' => false,
                'message' => 'This item is already in your favorites.',
            ];
        }

        // Create a new Favorito entry
        $favorito = new Favorito();
        $favorito->idperfil = $idperfil;
        $favorito->idartigo = $idartigo;

        // Use checkAccess to ensure the user is authorized to perform the action
        $this->checkAccess('create', $favorito);

        if ($favorito->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'success' => true,
                'message' => 'Item added to favorites successfully.',
                'favorito' => $favorito,
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'An error occurred while adding the item to favorites.',
                'errors' => $favorito->errors,
            ];
        }
    }

    public function actionDeletefavorito($id)
    {
        $favorito = Favorito::findOne($id);

        if (!$favorito) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Favorito not found.',
            ];
        }

        $this->checkAccess('delete', $favorito);

        if ($favorito->delete()) {
            Yii::$app->response->statusCode = 200;
            return [
                'success' => true,
                'message' => 'Favorite removed successfully.',
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'An error occurred while removing the favorite.',
            ];
        }
    }



    public function actionUser($id)
    {
        $favoritos = Favorito::find()
            ->with([
                'artigo',               // Carrega a relação com o artigo
                'artigo.idcomissao0',   // Carrega a comissão associada ao artigo
                'artigo.idestado0',     // Carrega o estado do artigo
                'artigo.idmarca0',      // Carrega a marca do artigo
                'artigo.idcategoria0',  // Carrega a categoria do artigo
                'artigo.idtamanho0',    // Carrega o tamanho do artigo
                'artigo.idperfil0',     // Carrega o perfil associado ao artigo
            ])
            ->where(['idperfil' => $id]) // Filtra pelo ID do perfil
            ->all();

        $this->checkAccess('view', $favoritos, ['id' => $id]);

        // Verifica se encontrou algum favorito
        if (!$favoritos) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'No favourites found for this user',
            ];
        }

        // Formata os favoritos com detalhes dos artigos
        $favoritosFormatted = [];
        foreach ($favoritos as $favorito) {

            $fotos = [];
            foreach ($favorito->artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }
            $artigo = $favorito->artigo;
            $favoritosFormatted[] = [
                'id' => $favorito->id,
                'idartigo' => $favorito->idartigo,
                'artigo' => $artigo ? [
                    'nome' => $artigo->nome,
                    'descricao' => $artigo->descricao,
                    'precoanuncio' => $artigo->precoanuncio,
                    'comissao' => $artigo->idcomissao0->comissao,
                    'estado' => $artigo->idestado0->descricao,
                    'marca' => $artigo->idmarca0->nome,
                    'categoria' => $artigo->idcategoria0->nome,
                    'tamanho' => $artigo->idtamanho0->tamanho,
                    'username' => $artigo->idperfil0->user->username,
                    'tipoartigo' => $artigo->tipoartigo,
                    'fotos' => $fotos,
                ] : null,
            ];
        }

        return [
            'success' => true,
            'favoritos' => $favoritosFormatted,
        ];
    }

}
