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
    'pagination' => false,

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
                            'idchat' => $chatAtual->id,
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
                            'idchat' => $chatAtual->id,
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
    scrollToBottom();



    const options = {
        hostname: "127.0.0.1",
        port: 9001,
        clientId: "client_" + Math.random().toString(16).substr(2, 8),
        username: "<?= Yii::$app->user->identity->username ?>",
        password: "password"
    };


    const client = mqtt.connect(`ws://${options.hostname}:${options.port}`, {
        clientId: options.clientId,
        username: options.username,
        password: options.password
    });


    client.on("connect", function () {
        console.log("Connected to MQTT Broker via WebSocket.");

        // Inscrever-se no tópico 'chat/<?= $chatAtual->id ?>'
        const topic = "chat/<?= $chatAtual->id ?>";
        client.subscribe(topic, function (err) {
            if (!err) {
                console.log("Topic subscribed: " + topic);
            } else {
                console.error("Error subscribing this topic: " + err);
            }
        });
    });


    client.on("message", function (topic, message) {
        console.log("Message: " + message.toString());

        try {
            const data = JSON.parse(message.toString());
            renderMessage(data);
        } catch (e) {
            console.error("Error processing message:", e);
        }
    });


    client.on("error", function (err) {
        console.error("Connection Error: " + err);
    });

    function renderMessage(data) {
        const isOutgoing = data.idUser === <?= Yii::$app->user->identity->id ?>;

        if (data.tipo === "TEXTO") {
            renderTextMessage(data, isOutgoing);
        } else if (data.tipo === "PROPOSTA") {
            renderPropostaMessage(data, isOutgoing);
        } else {
            console.error("Unknown message type:", data.tipo);
        }

        scrollToBottom();
    }
    function renderTextMessage(data, isOutgoing) {
        const chatCard = document.createElement("div");
        chatCard.classList.add("chat", isOutgoing ? "outgoing" : "incoming");

        const details = document.createElement("div");
        details.classList.add("details");

        const messageText = document.createElement("p");
        messageText.textContent = data.descricao;

        details.appendChild(messageText);
        chatCard.appendChild(details);
        chatContainer.appendChild(chatCard);
    }

    function renderPropostaMessage(data, isOutgoing) {

        if (data.estado === 0) {
            const chatCard = document.createElement("div");
            chatCard.classList.add("chat", isOutgoing ? "outgoing" : "incoming");

            const details = document.createElement("div");
            details.classList.add("details");
            details.setAttribute("data-index", data.idProposta);

            const propostaContainer = document.createElement("div");
            propostaContainer.classList.add(
                "d-flex",
                "flex-column",
                "justify-content-center",
                "align-items-center",
                "p-2",
                isOutgoing ? "cardProposta" : "propostaEsq"
            );


            const priceRow = document.createElement("div");
            priceRow.classList.add("d-flex", "gap-2");

            const propostaPrice = document.createElement("span");
            propostaPrice.classList.add("font-weight-bold");
            propostaPrice.textContent = `${parseFloat(data.preco).toFixed(2).replace('.', ',')}€`;
            priceRow.appendChild(propostaPrice);

            const artigoPriceContainer = document.createElement("div");
            artigoPriceContainer.classList.add("position-relative");

            const artigoPrice = document.createElement("span");
            artigoPrice.textContent = `${parseFloat(data.artigoPreco).toFixed(2).replace('.', ',')}€`;
            artigoPriceContainer.appendChild(artigoPrice);

            const divider = document.createElement("img");
            divider.src = "/img/dividerPropose.svg";
            divider.alt = "";
            divider.style.position = "absolute";
            divider.style.right = "3px";
            divider.style.top = "11px";
            divider.style.height = "3px";
            artigoPriceContainer.appendChild(divider);

            priceRow.appendChild(artigoPriceContainer);
            propostaContainer.appendChild(priceRow);


            const propostaStatus = document.createElement("span");
            if (!isOutgoing) {
                const buttonContainer = document.createElement("div");
                buttonContainer.classList.add("d-flex", "gap-2");

                const rejectButton = document.createElement("a");
                rejectButton.classList.add(
                    "btn",
                    "retroverse-btn",
                    "active",
                    "w-auto",
                    "px-3",
                    "py-0",
                    "rounded-3",
                    "text-white"
                );
                rejectButton.textContent = "x";
                rejectButton.href = `<?= \yii\helpers\Url::to(['mensagemproposta/update']) ?>?id=${data.idProposta}&state=1`;
                rejectButton.setAttribute("id", "retroverse-btn-active");
                buttonContainer.appendChild(rejectButton);


                const acceptButton = document.createElement("a");
                acceptButton.classList.add(
                    "btn",
                    "retroverse-btn",
                    "active",
                    "w-auto",
                    "px-3",
                    "py-0",
                    "rounded-3",
                    "text-white"
                );
                acceptButton.textContent = "accept";
                acceptButton.href = `<?= \yii\helpers\Url::to(['mensagemproposta/update']) ?>?id=${data.idProposta}&state=2`;
                acceptButton.setAttribute("id", "retroverse-btn-active");
                buttonContainer.appendChild(acceptButton);

                propostaContainer.appendChild(buttonContainer);
            }
            details.appendChild(propostaContainer);
            chatCard.appendChild(details);
            chatContainer.appendChild(chatCard);
        }
        else {
            const detailsDiv = document.querySelector(`.cardProposta[data-index="${data.idProposta}"]`);

            if (detailsDiv) {
                const propostaStatus = detailsDiv.querySelector(".status");
                if (data.estado === "1") {
                    propostaStatus.classList.add("text-danger");
                    propostaStatus.textContent = "Recusado";
                } else if (data.estado === "2") {
                    propostaStatus.classList.remove("text-warning");
                    propostaStatus.classList.add("text-success");
                    propostaStatus.textContent = "Accept";

                        const addToCartButton = document.createElement("a");
                        addToCartButton.classList.add(
                            "btn",
                            "retroverse-btn",
                            "active",
                            "w-auto",
                            "px-3",
                            "py-0",
                            "rounded-3",
                            "text-white"
                        );
                    addToCartButton.setAttribute("id", "retroverse-btn-active");
                        addToCartButton.textContent = "ADD";
                    addToCartButton.href = "<?= \yii\helpers\Url::to(['carrinho/create', 'id' => $chatAtual->idartigo]) ?>";
                    detailsDiv.appendChild(addToCartButton);
                }
            }
        }
    }
    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
</script>
