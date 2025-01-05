<?php

namespace backend\modules\api\controllers;
use common\models\Artigo;
use common\models\Categoriaartigo;
use common\models\Estado;
use common\models\Marca;
use common\models\Tamanho;
use common\models\User;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\rest\ActiveController;
use backend\modules\api\components\CustomAuth;
use yii\web\ForbiddenHttpException;
use Yii;


/**
 * Default controller for the `api` module
 */

class ArtigoController extends ActiveController
{
    public $modelClass = 'common\models\Artigo';
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

        if ($user_) {
            $this->user = $user_;
            return $user_;
        }


        throw new \yii\web\ForbiddenHttpException('No authentication');
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($this->user) {
            if ($action === 'update' || $action === 'create') {
                if ($model) {
                    if ($model->idperfil !== $this->user->id) {
                        throw new ForbiddenHttpException('You don´t have permission to create or edit this item!');
                    }
                }
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
        if (Yii::$app->request->method !== 'GET' && Yii::$app->request->method !== 'POST' && Yii::$app->request->method !== 'PUT') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'THIS METHOD IS NOT ALLOWED!'
            ];
            return false;
        }
        return true;
    }

    public function actionFiltro()
    {
        $query = Artigo::find()
            ->joinWith(['idestado0', 'idmarca0', 'idtamanho0', 'idcategoria0', 'idperfil0', 'fotosartigos']);

        $params = Yii::$app->request->queryParams;

        if (isset($params['tipoartigo'])) {
            $query->andWhere(['tipoartigo' => $params['tipoartigo']]);
        }
        if (isset($params['tamanho'])) {
            $query->andWhere(['Tamanhos.tamanho' => $params['tamanho']]);
        }
        if (isset($params['estado'])) {
            $query->andWhere(['Estados.descricao' => $params['estado']]);
        }
        if (isset($params['marca'])) {
            $query->andWhere(['Marcas.nome' => $params['marca']]);
        }
        if (isset($params['categoria'])) {
            $query->andWhere(['Categorias.nome' => $params['categoria']]);
        }

        if (isset($params['sort'])) {
            $query->orderBy($params['sort']);
        }

        $artigos = $query->all();
        $result = [];

        foreach ($artigos as $artigo) {
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
            ];
        }

        return $result;
    }


    public function actionArtigodetalhes($id)
    {
        $artigo = Artigo::find()
            ->with(['idestado0', 'idmarca0', 'idtamanho0', 'idcategoria0', 'idperfil0', 'fotosartigos'])
            ->where(['id' => $id])
            ->one();

        if (!$artigo) {
            throw new \yii\web\NotFoundHttpException("ITEM NOT FOUND");
        }

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
                'descricao' => $artigo->idperfil0->descricao,
                'caminhofotoperfil' => $artigo->idperfil0->caminhofotoperfil,
                'morada' => $artigo->idperfil0->morada,
            ] : null,
        ];
    }


    public function actionUserartigos($userid)
    {
        // Buscar todos os artigos associados ao perfil com todas as relações necessárias
        $artigos = Artigo::find()
            ->with(['idestado0', 'idmarca0', 'idtamanho0', 'idcategoria0', 'idperfil0', 'fotosartigos'])
            ->where(['idperfil' => $userid])
            ->all();

        // Se não houver artigos, lançar uma exceção
        if (!$artigos) {
            throw new \yii\web\NotFoundHttpException("Nenhum artigo encontrado para o perfil.");
        }

        // Formatar os resultados
        $resultado = [];
        foreach ($artigos as $artigo) {
            $fotos = [];
            foreach ($artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }

            $resultado[] = [
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
            ];
        }

        return $resultado;
    }


    public function actionCriarartigo()
    {
        $model = new Artigo();

        $this->checkAccess('create', $model);

        $request = Yii::$app->request->post();
        if ($model->load($request, '')) {
            $model->datacriacao = date('Y-m-d H:i:s');

            $model->idperfil = $this->user->id;
            $model->nome = $request['nome'] ?? null;
            $model->descricao = $request['descricao'] ?? null;
            $model->precoanuncio = $request['precoanuncio'] ?? null;
            $model->idcomissao = $request['idcomissao'] ?? null;
            $model->idestado = $request['idestado'] ?? null;
            $model->idmarca = $request['idmarca'] ?? null;
            $model->idcategoria = $request['idcategoria'] ?? null;
            $model->idtamanho = $request['idtamanho'] ?? null;
            $model->tipoartigo = $request['tipoartigo'] ?? 'LOJA';
            $model->ativo = $request['ativo'] ?? 1;

            if ($model->validate()) {

                $transaction = Yii::$app->db->beginTransaction();
                try {

                    if ($model->save()) {

                        $transaction->commit();

                        return [
                            'status' => 'success',
                            'message' => 'Artigo criado com sucesso!',
                            'artigo' => $model,
                        ];
                    } else {
                        throw new \Exception('Erro ao salvar o artigo.');
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return [
                        'status' => 'error',
                        'message' => 'Erro ao criar o artigo: ' . $e->getMessage(),
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Erro de validação.',
                    'errors' => $model->errors,
                ];
            }
        }

        return [
            'status' => 'error',
            'message' => 'Dados não foram enviados corretamente.',
        ];
    }




    public function actionEditarartigo($id)
    {
        $model = Artigo::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Artigo não encontrado.');
        }

        $this->checkAccess('update', $model);

        $data = json_decode(Yii::$app->request->getRawBody(), true);


        if ($model->load($data, '')) {
            if ($model->validate()) {
                if ($model->save()) {
                    return [
                        'status' => 'success',
                        'message' => 'Artigo atualizado com sucesso!',
                    ];
                } else {

                    return [
                        'status' => 'error',
                        'message' => 'Erro ao salvar o artigo.',
                        'errors' => $model->errors,
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Erro de validação.',
                    'errors' => $model->errors,

                ];
            }
        }
        return [
            'status' => 'error',
            'message' => 'Dados não foram enviados corretamente.',
        ];
    }



    //FUNCAO DE CRIACAO DE UM ARTIGO (MAS COM PARAMETROS EM STRING)
//    public function actionCriarartigo()
//    {
//        $model = new Artigo();
//        $request = Yii::$app->request->post();
//        $userId = $request['iduser'] ?? null;
//
//
//        $transaction = Yii::$app->db->beginTransaction();
//
//        try {
//            if (Yii::$app->request->isPost) {
//                $model->load($request, '');
//
//                $model->datacriacao = date('Y-m-d H:i:s');
//                $model->nome = $request['nome'] ?? null;
//                $model->descricao = $request['descricao'] ?? null;
//                $model->precoanuncio = $request['precoanuncio'] ?? null;
//                $model->idcomissao = $request['idcomissao'] ?? null;
//                $model->idcomissao = $request['idcomissao'] ?? null;
//
//                if (!empty($request['estado'])) {
//                    $estado = Estado::find()->where(['descricao' => $request['estado']])->one();
//                    if ($estado) {
//                        $model->idestado = $estado->id;
//                    } else {
//                        throw new \Exception("State not found " . $request['estado']);
//                    }
//                }
//
//                if (!empty($request['nomemarca'])) {
//                    $marca = Marca::find()->where(['nome' => $request['nomemarca']])->one();
//                    if ($marca) {
//                        $model->idmarca = $marca->id;
//                    } else {
//                        throw new \Exception("Brand not found " . $request['nomemarca']);
//                    }
//                }
//
//                if (!empty($request['categoria'])) {
//                    $categoria = Categoriaartigo::find()->where(['nome' => $request['categoria']])->one();
//                    if ($categoria) {
//                        $model->idcategoria = $categoria->id;
//                    } else {
//                        throw new \Exception("Category not found " . $request['categoria']);
//                    }
//                }
//
//                if (!empty($request['tamanho'])) {
//                    $tamanho = Tamanho::find()->where(['tamanho' => $request['tamanho']])->one();
//                    if ($tamanho) {
//                        $model->idtamanho = $tamanho->id;
//                    } else {
//                        throw new \Exception("Size not found " . $request['tamanho']);
//                    }
//                }
//
//                $model->idperfil = $userId; // ID do perfil
//                $model->tipoartigo = $request['tipoartigo'] ?? null;
//                $model->ativo = 1;
//
//                if (!$model->save()) {
//                    throw new \Exception('Error: This item could not be saved ');
//                }
//
//                $transaction->commit();
//
//                return [
//                    'status' => 'success',
//                    'message' => 'Item added with success',
//                    'artigo' => $model,
//                ];
//            }
//        } catch (\Exception $e) {
//            $transaction->rollBack();
//            return [
//                'status' => 'error',
//                'message' => 'Error creating this item: ' . $e->getMessage(),
//            ];
//        }
//    }
}
