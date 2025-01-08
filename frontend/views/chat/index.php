<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */


?>
<div class="chat-view my-5 w-100 d-flex justify-content-center">
    <div class="container card row d-flex flex-row p-0" style="min-height: 650px">
        <div class="col-md-4 card p-0 d-flex flex-column">
            <h2 class="text-start pl-5 text-uppercase card border-top-0"> <strong>MESSAGES</strong></h2>
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_list-chat',
                'options' => ['class' => 'list-view'],
                'layout' => '<div class="row m-0">{items}</div>',
                'itemOptions' => ['class' => 'col-12'],
            ]); ?>
        </div>
        <div class="col-md-8 p-0 d-flex flex-column">


        </div>
    </div>
</div>

