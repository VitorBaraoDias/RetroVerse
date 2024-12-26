<?php

namespace backend\modules\api\controllers;
use common\models\Artigo;
use yii\rest\Controller;
use yii\rest\ActiveController;
use Yii;

/**
 * Default controller for the `api` module
 */
class ArtigoController extends ActiveController
{
    //modelo a criar artigo
    public $modelClass = 'common\models\Artigo';


    public function BeforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->request->method !== 'GET') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'Este método não é permitido.'
            ];
            return false;
        }
        return true;
    }

    public function actionArtigofiltro($tipo = null, $tamanho = null, $estado = null, $marca = null)
    {
        $query = Artigo::find()
            ->joinWith(['idestado0', 'idmarca0', 'idtamanho0', 'idcategoria0', 'idperfil0'])
            ->andFilterWhere(['tipoartigo' => $tipo])
            ->andFilterWhere(['Tamanhos.tamanho' => $tamanho])
            ->andFilterWhere(['Estados.descricao' => $estado])
            ->andFilterWhere(['Marcas.nome' => $marca])
            ->all();

        $result = [];

        foreach ($query as $artigo) {

            $fotos = [];
            foreach ($artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }
            $result[] = [
                'id' => $artigo->id,
                'datacriacao' => Yii::$app->formatter->asDate($artigo->datacriacao, 'dd/MM/yyyy'),
                'nome' => $artigo->nome,
                'descricao' => $artigo->descricao,
                'precoanuncio' => $artigo->precoanuncio,
                'comissao' => $artigo->idcomissao0->comissao,
                'estado' => $artigo->idestado0->descricao,
                'marca' => $artigo->idmarca0->nome,
                'categoria' => $artigo->idcategoria0->nome,
                'tamanho' => $artigo->idtamanho0->tamanho,
                'tipoartigo' => $artigo->tipoartigo,
                'ativo' => $artigo->ativo ? 'Sim' : 'Não',
                'fotos' => $fotos,  // Adicionando as fotos ao resultado

                'perfil' => [
                    'id' => $artigo->idperfil0->id,
                    'username' => $artigo->idperfil0->username,
                    'descricao' => $artigo->idperfil0->descricao,
                    'caminhofotoperfil' => $artigo->idperfil0->caminhofotoperfil,
                    'morada' => $artigo->idperfil0->morada,
                ],
            ];
        }

        return $result;
    }

    public function actionDetalhesArtigo($id)
    {
        // Buscar o artigo com as relações necessárias
        $artigo = Artigo::find()
            ->with(['idestado0', 'idmarca0', 'idtamanho0', 'idcategoria0', 'idperfil0']) // Eager loading das relações
            ->where(['id' => $id])
            ->one();

        // Se o artigo não for encontrado, lançar uma exceção
        if (!$artigo) {
            throw new \yii\web\NotFoundHttpException("Artigo não encontrado.");
        }

        // Montar o resultado substituindo os IDs pelos nomes
        return [
            'id' => $artigo->id,
            'datacriacao' => Yii::$app->formatter->asDate($artigo->datacriacao, 'dd/MM/yyyy'),
            'nome' => $artigo->nome,
            'descricao' => $artigo->descricao,
            'precoanuncio' => $artigo->precoanuncio,
            'comissao' => $artigo->idcomissao0->comissao,
            'estado' => $artigo->idestado0 ? $artigo->idestado0->descricao : null, // Estado pelo nome
            'marca' => $artigo->idmarca0 ? $artigo->idmarca0->nome : null, // Marca pelo nome
            'categoria' => $artigo->idcategoria0 ? $artigo->idcategoria0->nome : null, // Categoria pelo nome
            'tamanho' => $artigo->idtamanho0 ? $artigo->idtamanho0->tamanho : null, // Tamanho pelo nome
            'tipoartigo' => $artigo->tipoartigo,
            'ativo' => $artigo->ativo ? 'Sim' : 'Não',
            'fotos' => array_map(function ($foto) {
                return $foto->caminhofoto;
            }, $artigo->fotosartigos), // Fotos dos artigos
            'perfil' => [
                'id' => $artigo->idperfil0->id,
                'username' => $artigo->idperfil0->username,
                'descricao' => $artigo->idperfil0->descricao,
                'caminhofotoperfil' => $artigo->idperfil0->caminhofotoperfil,
                'morada' => $artigo->idperfil0->morada,
            ]
        ];
    }

}
