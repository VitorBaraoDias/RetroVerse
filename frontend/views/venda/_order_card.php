<?php

use yii\helpers\Html;

/** @var $model \common\models\Venda */


$model->checkAndSetNextState();

$status = $model->estadoEncomenda->descricao ?? 'N/A';
$statusColor = $model->estadoEncomenda && $model->estadoEncomenda->isFinalState() ? 'green' : 'grey';
?>

<div class="history-order-box border p-3 rounded shadow-sm">
    <div class="history-order-total text-end">
        <span>TOTAL:</span> €<?= $model->total ?>
    </div>

    <div class="history-order-info">
        <h6>ORDER #<?= $model->codigo ?></h6>
        <h3><?= Html::encode($model->getLinhavendas()->count()) ?> ITEMS</h3>
        <p><span>STATUS: </span><span style="color: <?= $statusColor ?>; font-weight: bold;"><?= Html::encode($status) ?></span></p>
    </div>

    <div class="history-buttons text-end">

        <?= Html::a('VIEW ORDER DETAILS', ['venda/view', 'id' => $model->id], ['class' => 'history-view-details']) ?>
        <?= Html::a('VIEW INVOICE', ['venda/viewinvoice', 'id' => $model->id], ['class' => 'history-view-invoice']) ?>
    </div>
</div>
