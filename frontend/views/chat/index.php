<?php

use common\models\Listachats;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */


?>
<div class="chat-view my-5 w-100 d-flex justify-content-center">
    <div class="container card row d-flex flex-row p-0" style="min-height: 650px">
        <div class="col-md-4 card p-0 d-flex flex-column">
            <h2 class="text-start pl-5 text-uppercase card">MESSAGES</h2>

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


        </div>
    </div>
</div>

