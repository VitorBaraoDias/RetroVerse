<?php

use common\models\Conversa;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\Listachats $model */

\yii\web\YiiAsset::register($this);

$perfil = $chatAtual->getDestinatarioOuRemetente();

$dataProviderChata = new ActiveDataProvider([
    'query' => Conversa::find()->where(['idchat' => $chatAtual->id]),
]);


?>
<div class="chat-view my-5 w-100 d-flex justify-content-center">
    <div class="container card row d-flex flex-row p-0" style="min-height: 650px">
        <div class="col-md-4 card p-0 d-flex flex-column">
            <h2 class="text-start pl-5 text-uppercase card">MESSAGES</h2>
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
            <h2 class="text-center text-uppercase card" style="color: #0000FF"><?= $perfil->user->username ?></h2>

            <?= ListView::widget([
                'dataProvider' => $dataProviderChata,
                'itemView' => '../conversa/_chat',
                'layout' => '<div class="chat-box">{items}</div>',
            ]) ?>
            <div style="margin-top: auto;">
                <?= $this->render('../conversa/create', [
                    'model' => $modelConversa,
                    'idchat' => $chatAtual->id, // Passa o id do chat atual
                    'modelTexto' => $modelTexto,
                ]) ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.1.0/paho-mqtt.min.js"
        integrity="sha512-Y5n0fbohPllOQ21fTwM/h9sQQ/1a1h5KhweGhu2zwD8lAoJnTgVa7NIrFa1bRDIMQHixtyuRV2ubIx+qWbGdDA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    const chatId = <?= $chatAtual->id ?>;  // Obtendo o ID do chat diretamente no PHP
    const topic = `chat/${chatId}`;

    const client = new Paho.Client("localhost", 1883, "clientId-" + parseInt(Math.random() * 100, 10));
    // set callback handlers
    // set callback handlers
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    // connect the client
    client.connect({onSuccess:onConnect});


    // called when the client connects
    function onConnect() {
        // Once a connection has been made, make a subscription and send a message.
        console.log("onConnect");
        client.subscribe(topic);
        message = new Paho.Message("Hello");
        message.destinationName = "World";
        client.send(message);
    }

    // called when the client loses its connection
    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log("onConnectionLost:"+responseObject.errorMessage);
        }
    }

    // called when a message arrives
    function onMessageArrived(message) {
        console.log("onMessageArrived:"+message.payloadString);
    }

</script>
