<?php

namespace backend\modules\api\controllers;

use common\models\Favorito;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use Yii;

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

    public function actionFavorito($id)
    {
        $favoritos = Favorito::find()->where(['idperfil' => $id])->all();

        if (!$favoritos) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Nenhum favorito encontrado para o utilizador fornecido.',
            ];
        }

        $favoritos = Favorito::find()
            ->with([
                'artigo',        // Carrega a relação com o artigo
                'artigo.idestado0', // Carrega o estado do artigo
                'artigo.idmarca0', // Carrega a marca do artigo
                'artigo.idcategoria0', // Carrega a categoria do artigo
                'artigo.idtamanho0', // Carrega o tamanho do artigo
                'artigo.idperfil0', // Carrega o perfil associado ao artigo
            ])
            ->where(['idperfil' => $id])
            ->all();

        // Verifica se as linhas foram encontradas
        if (!$favoritos) {
            return [
                'success' => true,
                'carrinho' => [],
                'message' => 'Nenhuma favorito encontrado.',
            ];
        }

        $favoritoFormatted = [];

        foreach ($favoritos as $favorito) {
            $artigo = $favorito->artigo;

            $favoritoFormatted[] = [
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
                    'perfil' => "@" . $artigo->idperfil0->username,
                    'tipoartigo' => $artigo->tipoartigo,
                ] : null,
            ];
        }

        return [
            'success' => true,
            'favoritos' => $favoritoFormatted,
        ];
    }






    public function actionDeleteFavorito($userId, $favoritoId)
    {
        // Busca o favorito pelo ID do usuário e pelo ID do favorito
        $favorito = Favorito::find()->where(['idperfil' => $userId, 'id' => $favoritoId])->one();

        // Verifica se o favorito existe
        if (!$favorito) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Favorito não encontrado para o utilizador fornecido.',
            ];
        }

        // Exclui o favorito
        if ($favorito->delete()) {
            return [
                'success' => true,
                'message' => 'Favorito excluído com sucesso.',
            ];
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Erro ao excluir o favorito.',
            ];
        }
    }



}
