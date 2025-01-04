<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use common\models\Conversa;
use common\models\Listachats;
use common\models\Mensagemproposta;
use common\models\Mensagemtexto;
use Yii;
use yii\rest\ActiveController;


class ChatController  extends ActiveController
{
    public $modelClass = 'common\models\Conversa';

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create']);

        return $actions;
    }
    public function actionConversas($idchat)
    {
        // Procura conversas do utilizador onde o tipo é 'TEXTO'
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
                        'preco' => $mensagem->mensagemproposta->preco,
                        'estado' => $mensagem->mensagemproposta->estado,
                        'idartigo' => $mensagem->mensagemproposta->idartigo,
                    ]
                ];
            }

        }
        return $resultados;
    }

    public function actionListachats($iduser)
    {
        // Procura os chats onde o user é o remetente ou o destinatário
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

        //criar o chat
        $idartigo = $request['idartigo'] ?? null;
        $idremetente = $request['idremetente'] ?? null;

        $this->verifyIfChatExists($idartigo, $idremetente); //cria o cbat
        //criar a mensagem

        $tipo = $request['tipo'] ?? null;
        if ($tipo == 'TEXTO'){

        }else if ($tipo == 'PROPOSTA'){

        }

    }

    private function verifyIfChatExists($idartigo, $iduser)
    {
        $artigo = Artigo::findOne($idartigo);

        if ($artigo === null) {
            throw new \yii\web\NotFoundHttpException('Artigo não encontrado.');
        }

        $idVisitante = $iduser;
        $idVendedor = $artigo->idperfil;

        // Verifica se já existe um chat entre o vendedor e o visitante
        $chatAtual = Listachats::find()
            ->where([
                'idremetente' => $idVisitante,
                'iddestinatario' => $idVendedor
            ])
            ->orWhere([
                'idremetente' => $idVendedor,
                'iddestinatario' => $idVisitante
            ])
            ->one();


        // Cria o chat se não existir
        if (is_null($chatAtual)) {
            $chatAtual = new Listachats();
            $chatAtual->idremetente = $idVisitante;
            $chatAtual->iddestinatario = $idVendedor;
            $chatAtual->idartigo = $artigo->id;
            if(!$chatAtual->save()){
                return throw new \yii\web\NotFoundHttpException('Chat could not be created');
            }
        }
        return true;



    }


}