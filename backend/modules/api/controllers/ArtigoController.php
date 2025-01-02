<?php

namespace backend\modules\api\controllers;
use common\models\Artigo;
use common\models\Categoriaartigo;
use common\models\Estado;
use common\models\Marca;
use common\models\Tamanho;
use yii\filters\auth\QueryParamAuth;
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

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
    public function BeforeAction($action)
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

    public function actionArtigofiltro($tipoartigo = null, $tamanho = null, $estado = null, $marca = null)
    {
        $query = Artigo::find()
            ->joinWith(['idestado0', 'idmarca0', 'idtamanho0', 'idcategoria0', 'idperfil0'])
            ->andFilterWhere(['tipoartigo' => $tipoartigo])
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
                'fotos' => $fotos,

                'perfil' => [
                    'id' => $artigo->idperfil0->id,
                    'username' => $artigo->idperfil0->user->username,
                    'descricao' => $artigo->idperfil0->descricao,
                    'caminhofotoperfil' => $artigo->idperfil0->caminhofotoperfil,
                    'morada' => $artigo->idperfil0->morada,
                ],
            ];
        }

        return $result;
    }

    public function actionArtigodetalhes($id)
    {
        // Buscar o artigo com todas as relações necessárias
        $artigo = Artigo::find()
            ->with(['idestado0', 'idmarca0', 'idtamanho0', 'idcategoria0', 'idperfil0', 'fotosartigos'])
            ->where(['id' => $id])
            ->one();

        // Se o artigo não for encontrado, lançar uma exceção
        if (!$artigo) {
            throw new \yii\web\NotFoundHttpException("ITEM NOT FOUND");
        }

        // Montar o resultado substituindo os IDs pelos nomes e outras informações
        $fotos = [];
        foreach ($artigo->fotosartigos as $foto) {
            $fotos[] = $foto->caminhofoto;
        }

        return [
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
            'ativo' => $artigo->ativo ? 'Sim' : 'Não',
            'fotos' => $fotos,
            'perfil' => $artigo->idperfil0 ? [
                'id' => $artigo->idperfil0->id,
                'username' => $artigo->idperfil0->username,
                'descricao' => $artigo->idperfil0->descricao,
                'caminhofotoperfil' => $artigo->idperfil0->caminhofotoperfil,
                'morada' => $artigo->idperfil0->morada,
            ] : null,
        ];
    }

    public function actionCriarartigo()
    {
        $model = new Artigo();
        $request = Yii::$app->request->post();
        $userId = $request['iduser'] ?? null;


        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (Yii::$app->request->isPost) {
                $model->load($request, '');

                $model->datacriacao = date('Y-m-d H:i:s');
                $model->nome = $request['nome'] ?? null;
                $model->descricao = $request['descricao'] ?? null;
                $model->precoanuncio = $request['precoanuncio'] ?? null;
                $model->idcomissao = $request['idcomissao'] ?? null;

                if (!empty($request['estado'])) {
                    $estado = Estado::find()->where(['descricao' => $request['estado']])->one();
                    if ($estado) {
                        $model->idestado = $estado->id;
                    } else {
                        throw new \Exception("State not found " . $request['estado']);
                    }
                }

                if (!empty($request['nomemarca'])) {
                    $marca = Marca::find()->where(['nome' => $request['nomemarca']])->one();
                    if ($marca) {
                        $model->idmarca = $marca->id;
                    } else {
                        throw new \Exception("Brand not found " . $request['nomemarca']);
                    }
                }

                if (!empty($request['categoria'])) {
                    $categoria = Categoriaartigo::find()->where(['nome' => $request['categoria']])->one();
                    if ($categoria) {
                        $model->idcategoria = $categoria->id;
                    } else {
                        throw new \Exception("Category not found " . $request['categoria']);
                    }
                }

                if (!empty($request['tamanho'])) {
                    $tamanho = Tamanho::find()->where(['tamanho' => $request['tamanho']])->one();
                    if ($tamanho) {
                        $model->idtamanho = $tamanho->id;
                    } else {
                        throw new \Exception("Size not found " . $request['tamanho']);
                    }
                }

                $model->idperfil = $userId; // ID do perfil
                $model->tipoartigo = $request['tipoartigo'] ?? null;
                $model->ativo = 1;

                if (!$model->save()) {
                    throw new \Exception('Error: This item could not be saved ');
                }

                $transaction->commit();

                return [
                    'status' => 'success',
                    'message' => 'Item added with success',
                    'artigo' => $model,
                ];
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return [
                'status' => 'error',
                'message' => 'Error creating this item: ' . $e->getMessage(),
            ];
        }
    }


    public function actionEditarartigo($id)
    {
        $model = Artigo::findOne($id);

        if (!$model) {
            return [
                'status' => 'error',
                'message' => 'Item not found.',
            ];
        }

        $request = Yii::$app->request->bodyParams;
        $userId = $request['iduser'] ?? null;

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (Yii::$app->request->isPut) {
                $model->load($request, '');


                $model->nome = $request['nome'] ?? $model->nome;
                $model->descricao = $request['descricao'] ?? $model->descricao;
                $model->precoanuncio = $request['precoanuncio'] ?? $model->precoanuncio;
                $model->idcomissao = $request['idcomissao'] ?? $model->idcomissao;

                if (!empty($request['estado'])) {
                    $estado = Estado::find()->where(['descricao' => $request['estado']])->one();
                    if ($estado) {
                        $model->idestado = $estado->id;
                    } else {
                        throw new \Exception("Size not found: " . $request['estado']);
                    }
                }

                if (!empty($request['nomemarca'])) {
                    $marca = Marca::find()->where(['nome' => $request['nomemarca']])->one();
                    if ($marca) {
                        $model->idmarca = $marca->id;
                    } else {
                        throw new \Exception("Brand not found: " . $request['nomemarca']);
                    }
                }

                if (!empty($request['categoria'])) {
                    $categoria = Categoriaartigo::find()->where(['nome' => $request['categoria']])->one();
                    if ($categoria) {
                        $model->idcategoria = $categoria->id;
                    } else {
                        throw new \Exception("Category not found: " . $request['categoria']);
                    }
                }

                if (!empty($request['tamanho'])) {
                    $tamanho = Tamanho::find()->where(['tamanho' => $request['tamanho']])->one();
                    if ($tamanho) {
                        $model->idtamanho = $tamanho->id;
                    } else {
                        throw new \Exception("Size not found: " . $request['tamanho']);
                    }
                }

                $model->idperfil = $userId ?? $model->idperfil;
                $model->tipoartigo = $request['tipoartigo'] ?? $model->tipoartigo;
                $model->ativo = $request['ativo'] ?? $model->ativo;

                if (!$model->save()) {
                    throw new \Exception('Error saving this item ');
                }

                $transaction->commit();

                return [
                    'status' => 'success',
                    'message' => 'Item updated with success.',
                    'artigo' => $model,
                ];
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return [
                'status' => 'error',
                'message' => 'Error updating this item: ' . $e->getMessage(),
            ];
        }
    }








}
