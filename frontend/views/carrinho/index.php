<?php

use yii\helpers\Html;
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

    <div class="p-4" style="display: flex;
    justify-content: flex-end;">
        <div>
            <p class="mb-4 text-center" style="font-size:12px; font-weight: bold">Total price and other fees calculated at checkout</p>
            <?= Html::a('CHECKOUT', ['venda/create'], [
                'class' => 'retroverse-btn active button-checkout',
                'id' => 'retroverse-btn-active',
                'style' => 'font-size: x-small; padding: 21px 95px;',
            ]) ?>
        </div>

    </div>

</div>
