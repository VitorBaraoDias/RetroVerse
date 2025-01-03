<?php

namespace backend\modules\api\controllers;

use common\models\Favorito;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class FavoritoController extends ActiveController
{
    public $modelClass = 'common\models\Favorito';


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            //'only' => ['favorito'], // Aplicar autenticação apenas ao método 'favorito'
        ];
        return $behaviors;
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
