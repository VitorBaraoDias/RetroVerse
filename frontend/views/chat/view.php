<?php

use common\models\Conversa;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var \common\models\Listachats $model */

\yii\web\YiiAsset::register($this);

$perfil = $chatAtual->getDestinatarioOuRemetente();

$dataProviderChata = new ActiveDataProvider([
    'query' => Conversa::find()->where(['idchat' => $chatAtual->id]),
    'pagination' => false,  // Desabilita a paginação.

]);


?>
<div class="chat-view my-5 w-100 d-flex justify-content-center">
    <div class="container card row d-flex flex-row p-0" style="min-height: 650px">
        <div class="card p-0">
            <div class="col-md-12 border-left-0 border-right-0 row p-0 m-0 border-0 py-2">
                <div class="col-md-4 m-0 card p-0 border-left-0 border-bottom-0 border-top-0 px-4">
                    <h2> <strong>MESSAGES</strong> </h2>
                </div>
                <div class="col-md-8 text-center text-uppercase">
                    <h2 style="color: #0000FF !important;"> <strong> <?= $perfil->user->username ?></strong> </h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 card p-0 d-flex flex-column border-top-0 ">
            <?php if ($chatAtual): ?>
                <div class="chat-atual">
                    <?= $this->render('_first_chat_item', ['model' => $chatAtual]) ?>
                </div>
            <?php endif; ?>
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list-chat',
                'options' => ['class' => 'list-view'],
                'layout' => '<div class="row">{items}</div>',
                'itemOptions' => ['class' => 'col-12'],
// Layout com itens e paginação
            ]); ?>
        </div>
        <div class="col-md-8 p-0 d-flex flex-column">
            <?= ListView::widget([
                'dataProvider' => $dataProviderChata,
                'itemView' => '../conversa/_chat',
                'layout' => '<div class="chat-box" id="chat">{items}</div>',
            ]) ?>
            <div style="margin-top: auto;" class="row mr-0 ml-0">
                <hr class="p-0 m-0 border-0">
                <?php if (Yii::$app->user->identity->id !== $chatAtual->artigo->idperfil): ?>
                    <div class="col-md-8  pt-3">
                        <?= $this->render('../conversa/create', [
                            'model' => $modelConversa,
                            'idchat' => $chatAtual->id, // Passa o id do chat atual
                            'modelTexto' => $modelTexto,
                        ]) ?></div>
                    <div class="col-md-4 pt-3">
                        <?= $this->render('../mensagemproposta/create', [
                            'model' => new \common\models\Mensagemproposta(),
                            'idchat' => $chatAtual->id,
                        ]) ?>
                    </div>
                <?php else: ?>
                    <div class="col-md-12  pt-3">
                        <?= $this->render('../conversa/create', [
                            'model' => $modelConversa,
                            'idchat' => $chatAtual->id, // Passa o id do chat atual
                            'modelTexto' => $modelTexto,
                        ]) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/mqtt@4.2.7/dist/mqtt.min.js"></script>

<script>
    const chatContainer = document.getElementById("chat");

    // Manter o scroll na parte inferior do chat
    chatContainer.scrollTop = chatContainer.scrollHeight;
    // Configurações de conexão
    const options = {
        hostname: "127.0.0.1",  // Endereço do broker
        port: 9001,  // Porta do WebSocket
        clientId: "client_" + Math.random().toString(16).substr(2, 8),
        username: "user1",  // Nome de usuário (se necessário)
        password: "password"  // Senha (se necessário)
    };

    // Criar uma nova instância do cliente MQTT
    const client = mqtt.connect(`ws://${options.hostname}:${options.port}`, options);

    // Quando o cliente se conectar ao broker
    client.on('connect', function () {
        console.log("Conectado ao broker MQTT via WebSocket");
        // Inscrever-se no tópico 'chat/12'
        client.subscribe('chat/${<?= $chatAtual->id ?>}', function (err) {
            if (!err) {
                console.log("Inscrito no tópico: chat/${<?= $chatAtual->id ?>}");
            } else {
                console.log("Erro ao se inscrever: " + err);
            }
        });
    });

    // Quando uma nova mensagem chegar
    client.on('message', function (topic, message) {
        console.log("Mensagem recebida: " + message.toString());
        //
        const data = JSON.parse(message.toString());
        const descricao = data.descricao;  // Acessar a propriedade "descricao"

        // Criar o div para o card de mensagem
        const chatCard = document.createElement("div");
        chatCard.classList.add("chat", "incoming");

        // Criar a div com os detalhes da mensagem
        const messageDetails = document.createElement("div");
        messageDetails.classList.add("details");

        // Criar o parágrafo com a descrição da mensagem
        const messageDescription = document.createElement("p");
        messageDescription.textContent = descricao; // Aqui você usa o conteúdo da mensagem

        // Adicionar o parágrafo dentro da div de detalhes
        messageDetails.appendChild(messageDescription);

        // Adicionar a div de detalhes dentro do card
        chatCard.appendChild(messageDetails);

        // Adicionar o card no container de mensagens
        chatContainer.appendChild(chatCard);    });
        chatContainer.scrollTop = chatContainer.scrollHeight;


    // Caso haja erro na conexão
    client.on('error', function (err) {
        console.log("Erro de conexão: " + err);
    });
</script>