<?php

use yii\helpers\Html;
use yii\widgets\ListView;


$this->title = 'Item Reports';
?>
<div class="denuncia-index">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_denuncia_card',
        'layout' => "{items}\n{pager}",
        'options' => ['class' => 'row'],
        'itemOptions' => ['class' => 'col-md-4 mb-4'],
    ]); ?>

</div>
