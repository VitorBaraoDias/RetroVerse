<?php

use common\models\Carrinho;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */


?>
<div class="carrinho-index">

<h1 class="text-center"><strong>CART</strong></h1>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_carrinho',
        'layout' => '<div class="row justify-content-center mt-4 gap-4">{items}</div>{pager}',
        'options' => ['class' => 'list-view'],
        'itemOptions' => ['class' => 'col-8 card p-4 d-flex flex-row justify-content-between'],
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'options' => ['class' => 'pagination justify-content-center'],
        ],
    ]) ?>

</div>
