<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Artigo;
use common\models\Conversa;
use common\models\Listachats;
use common\models\Mensagemproposta;
use common\models\Mensagemtexto;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class ChatController  extends ActiveController
{
    public $modelClass = 'common\models\Conversa';
    public $user = null;

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
            if ($action === 'view' || $action === 'create' || $action === 'listachats') {
                if ($model) {
                    if ($action === 'view' && $params['idremetente'] != $this->user->id && $params['iddestinatario'] != $this->user->id) {
                        throw new ForbiddenHttpException('You don´t have permission to view or edit this item!');
                    }
                    if($action === 'listachats' && $params['iduser'] != $this->user->id){
                        throw new ForbiddenHttpException('You don´t have permission to view or edit this item!');
                    }
                }
            }
        } else {
            throw new ForbiddenHttpException('User not authenticated.');
        }
    }
    public function actionConversas($idchat)
    {
        $chat = Listachats::find()->where(['id' => $idchat])->one();
        $this->checkAccess('view',$chat,
            ['idremetente' => $chat->idremetente, 'iddestinatario' => $chat->iddestinatario]);

        $conversas = Conversa::find()
            ->where(['idchat' => $idchat])
            ->all();

        $resultados = [];

        foreach ($conversas as $mensagem) {
            if($mensagem->tipo == 'TEXTO') {
                $resultados[] = [
                    'mensagem' => [
                        'idmensagem' => $mensagem->id,
                        'iduser' => $mensagem->iduser,
                        'idchat' => $mensagem->idchat,
                        'tipo' => $mensagem->tipo,
                        'descricao' => $mensagem->mensagem->descricao,
                    ]
                ];
            }

            else if($mensagem->tipo == 'PROPOSTA') {
                $resultados[] = [
                    'mensagem' => [
                        'idmensagem' => $mensagem->id,
                        'iduser' => $mensagem->iduser,
                        'idchat' => $mensagem->idchat,
                        'tipo' => $mensagem->tipo,
                        'preco' => $mensagem->mensagemproposta->preco ?? null,
                        'estado' => $mensagem->mensagemproposta->estado ?? null,
                        'idartigo' => $mensagem->mensagemproposta->idartigo ?? null,
                    ]
                ];
            }

        }
        return $resultados;
    }

    public function actionListachats($iduser)
    {
        $this->checkAccess('listachats', $this->modelClass ,['iduser' => $iduser]);

        $chats = Listachats::find()
            ->where(['idremetente' => $iduser])
            ->orWhere(['iddestinatario' => $iduser])
            ->all();
        $resultados = [];

        foreach ($chats as $chat) {
            $resultados[] = [
                'idchat' => $chat->id,
                'remetente' => $chat->remetente ? $chat->remetente->username : 'Desconhecido',
                'destinatario' => $chat->destinatario0 ? $chat->destinatario0->username : 'Desconhecido',
                'idartigo' => $chat->idartigo,
            ];
        }

        return $resultados;
    }
    public function actionCreate(){

        $request = Yii::$app->request->post();

        $idartigo = $request['idartigo'] ?? null;
        $idremetente = $request['idremetente'] ?? null;

        if (!$idartigo || !$idremetente) {
            throw new \yii\web\BadRequestHttpException('Parameters idartigo and idremente are mandatory.');
        }
        $chat = $this->verifyIfChatExistsAndReturn($idartigo, $idremetente); //cria o cbat

        $tipo = $request['tipo'] ?? null;

        if ($tipo === 'TEXTO' &&  $this->saveModelTextoAndModelConversa($request, $chat->id)) {
            return [
                'status' => 'success',
                'message' => 'Sent successfully'
            ];
        } elseif ($tipo === 'PROPOSTA' &&  $this->saveModelPropostaAndModelConversa($request, $chat)) {
            return [
                'status' => 'success',
                'message' => 'Sent propose successfully'
            ];
        } else {
            throw new \yii\web\BadRequestHttpException('Invalid message type.');
        }

    }
    private function verifyIfChatExistsAndReturn($idartigo, $iduser)
    {
        $artigo = Artigo::findOne($idartigo);

        if (!$artigo) {
            throw new \yii\web\NotFoundHttpException('Item not found.');
        }

        $chatAtual = Listachats::find()
            ->where(['or',
                ['idremetente' => $iduser, 'iddestinatario' => $artigo->idperfil],
                ['idremetente' => $artigo->idperfil, 'iddestinatario' => $iduser],
            ])
            ->one();

        if (!$chatAtual) {
            $chatAtual = new Listachats([
                'idremetente' => $iduser,
                'iddestinatario' => $artigo->idperfil,
                'idartigo' => $artigo->id,
            ]);

            if (!$chatAtual->save()) {
                throw new \yii\web\ServerErrorHttpException(
                    'Chat could not be created.'
                );
            }
        }
        return $chatAtual;
    }
    private function saveModelTextoAndModelConversa($request, $idChat){
        $modelTexto = new Mensagemtexto();
        $model = new Conversa();

        $descricao = $request['descricao'] ?? null;
        $modelTexto->descricao = $descricao;

        if ($modelTexto->save()) {
            $model->idchat = (int)$idChat;
            $model->iduser = $request['idremetente'];
            $model->idmensagem = $modelTexto->id;
            $model->tipo = 'TEXTO';
            return $model->save();
        }
    }
    private function saveModelPropostaAndModelConversa($request, $chat){
        $model = new Mensagemproposta();
        $conversa = new Conversa();

        $model->estado = 0;
        $model->preco = $request['preco'] ?? null;
        $model->iduser = $request['idremetente'];
        $model->idartigo = $chat->idartigo;
        $model->idchat = $chat->id;

        if ($model->save()) {

            $conversa->idchat = $chat->id;
            $conversa->iduser = $request['idremetente'];
            $conversa->idmensagem = $model->id;
            $conversa->tipo = 'PROPOSTA';
            return $conversa->save();
        }
    }

}