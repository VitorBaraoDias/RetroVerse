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
        $idperfil = $this->user->id;

        $artigo = Artigo::findOne($idartigo);
        if (!$artigo) {
            throw new ForbiddenHttpException('Item not found');

        }

        if ($artigo->idperfil == $idperfil) {
            throw new ForbiddenHttpException('You cannot add your own item to favorites.');
        }

        $existingFavorito = Favorito::find()
            ->where(['idperfil' => $idperfil, 'idartigo' => $idartigo])
            ->one();

        if ($existingFavorito) {
            throw new ForbiddenHttpException('This item is already in your favorites.');
        }

        $favorito = new Favorito();
        $favorito->idperfil = $idperfil;
        $favorito->idartigo = $idartigo;

        $this->checkAccess('create', $favorito);

        if ($favorito->save()) {
            $fotos = [];
            foreach ($artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }

            $perfil = $artigo->idperfil0;
            $quantidadeAvaliacoes = 0;
            $mediaAvaliacoes = 0.0;

            if ($perfil) {
                $avaliacoes = \common\models\Avaliacao::find()
                    ->where(['iddestinatario' => $perfil->id])
                    ->all();

                $quantidadeAvaliacoes = count($avaliacoes);

                if ($quantidadeAvaliacoes > 0) {
                    $mediaAvaliacoes = array_sum(array_column($avaliacoes, 'escala')) / $quantidadeAvaliacoes;
                }
            }

            $isPremium = (bool)\common\models\Artigospremium::find()
                ->where(['id' => $artigo->id])
                ->exists();

            $isLiked = (bool)\common\models\Favorito::find()
                ->where(['idartigo' => $artigo->id, 'idperfil' => $this->user->id])
                ->exists();

            $favoritoFormatted = [
                    'id' => $favorito->idartigo,
                    'nome' => $artigo->nome,
                    'descricao' => $artigo->descricao,
                    'precoanuncio' => $artigo->precoanuncio,
                    'comissao' => $artigo->idcomissao0->comissao ?? null,
                    'estado' => $artigo->idestado0->descricao ?? null,
                    'marca' => $artigo->idmarca0->nome ?? null,
                    'categoria' => $artigo->idcategoria0->nome ?? null,
                    'tamanho' => $artigo->idtamanho0->tamanho ?? null,
                    'tipoartigo' => $artigo->tipoartigo,
                    'fotos' => $fotos,
                    'perfil' => $perfil ? [
                        'id' => $perfil->id,
                        'username' => $artigo->idperfil0->user->username ?? null,
                        'descricao' => $perfil->descricao,
                        'caminhofotoperfil' => $perfil->caminhofotoperfil,
                        'morada' => $perfil->morada,
                        'quantidadeAvaliacoes' => $quantidadeAvaliacoes,
                        'mediaAvaliacoes' => round($mediaAvaliacoes, 2),
                    ] : null,
                    'isLiked' => $isLiked,
                    'isPremium' => $isPremium,
            ];

            Yii::$app->response->statusCode = 201;
            return
                $favoritoFormatted;
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
        $favorito = Favorito::find()->where(['idperfil' => $this->user->id, 'idartigo' => $id])->one();



        if (!$favorito) {
            Yii::$app->response->statusCode = 404;
            throw new ForbiddenHttpException('Favorito not found.');
        }

        $this->checkAccess('delete', $favorito);

        if ($favorito->delete()) {
            Yii::$app->response->statusCode = 200;
            return [];

        } else {
            Yii::$app->response->statusCode = 500;
            throw new ForbiddenHttpException('An error occurred while removing the favorite.');
        }
    }




    public function actionFavoritos()
    {
        if (!$this->user) {
            throw new ForbiddenHttpException('User not authenticated.');
        }

        $idperfil = $this->user->id;

        $favoritos = Favorito::find()
            ->with([
                'artigo',
                'artigo.idcomissao0',
                'artigo.idestado0',
                'artigo.idmarca0',
                'artigo.idcategoria0',
                'artigo.idtamanho0',
                'artigo.idperfil0',
            ])
            ->where(['idperfil' => $this->user->id])
            ->all();

        $this->checkAccess('view', $favoritos, ['id' => $this->user->id]);
        
        $favoritosFormatted = [];
        foreach ($favoritos as $favorito) {
            $fotos = [];
            foreach ($favorito->artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }

            $artigo = $favorito->artigo;
            $perfil = $artigo->idperfil0;

            $isPremium = (bool)\common\models\Artigospremium::find()
                ->where(['id' => $artigo->id])
                ->exists();


            $isLiked = (bool)\common\models\Favorito::find()
                ->where(['idartigo' => $artigo->id, 'idperfil' => $this->user->id])
                ->exists();

            $quantidadeAvaliacoes = 0;
            $mediaAvaliacoes = 0.0;

            if ($perfil) {
                $avaliacoes = \common\models\Avaliacao::find()
                    ->where(['iddestinatario' => $perfil->id])
                    ->all();

                $quantidadeAvaliacoes = count($avaliacoes);

                if ($quantidadeAvaliacoes > 0) {
                    $mediaAvaliacoes = array_sum(array_column($avaliacoes, 'escala')) / $quantidadeAvaliacoes;
                }
            }

            $favoritosFormatted[] = [
                    'id' => $favorito->idartigo,
                    'nome' => $artigo->nome,
                    'datacriacao' => $artigo->datacriacao,
                    'descricao' => $artigo->descricao,
                    'precoanuncio' => $artigo->precoanuncio,
                    'comissao' => $artigo->idcomissao0->comissao ?? null,
                    'estado' => $artigo->idestado0->descricao ?? null,
                    'marca' => $artigo->idmarca0->nome ?? null,
                    'categoria' => $artigo->idcategoria0->nome ?? null,
                    'tamanho' => $artigo->idtamanho0->tamanho ?? null,
                    'tipoartigo' => $artigo->tipoartigo,
                    'fotos' => $fotos,
                    'perfil' => $perfil ? [
                        'id' => $perfil->id,
                        'username' => $artigo->idperfil0->user->username ?? null,
                        'descricao' => $perfil->descricao,
                        'caminhofotoperfil' => $perfil->caminhofotoperfil,
                        'morada' => $perfil->morada,
                        'quantidadeAvaliacoes' => $quantidadeAvaliacoes,
                        'mediaAvaliacoes' => round($mediaAvaliacoes, 2),
                    ] : null,
                    'isLiked' => $isLiked,
                    'isPremium' => $isPremium,
            ];

        }
        return $favoritosFormatted;
    }
}
