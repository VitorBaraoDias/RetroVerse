<?php

use common\models\Conversa;
use common\models\Listachats;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$perfil = $chatAtual->getDestinatarioOuRemetente();

$dataProviderChata = new ActiveDataProvider([
    'query' => Conversa::find()->where(['idchat' => $chatAtual->id]),
]);
?>
<div class="chat-view my-5 w-100 d-flex flex-column align-items-center">
    <div>
        <h3 class="text-start pl-5 text-uppercase ">MESSAGES</h3>
        <h2 class="text-center text-uppercase " style="color: #0000FF"><?= $perfil->user->username ?></h2>
    </div>
    <div class="container card row d-flex flex-row p-0" style="min-height: 650px">
        <div class="col-md-4 card border-bottom-0 border-top-0 p-0 d-flex flex-column">
            <?php if ($chatAtual): ?>
                <div class="chat-atual">
                    <?= $this->render('_first_chat_item', ['model' => $chatAtual]) ?>
                </div>
            <?php endif; ?>
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => function ($model, $key, $index, $widget) use ($chatAtual) {
                    // Destaca o chat atual (este código não vai se aplicar ao chat atual, pois ele foi excluído da lista)
                    return $this->render('_list-chat', [
                        'model' => $model,
                    ]);
                },
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
                'layout' => '<div class="chat-box">{items}</div>',
            ]) ?>
            <div style="margin-top: auto;" class="p-2">
                <?= $this->render('../conversa/create', [
                    'model' => $modelConversa,
                    'idchat' => $chatAtual->id, // Passa o id do chat atual
                    'modelTexto' => $modelTexto,
                ]) ?>
            </div>
        </div>
    </div>
</div>

