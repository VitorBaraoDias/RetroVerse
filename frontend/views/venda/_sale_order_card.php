<?php
use yii\helpers\Html;

/** @var $model \common\models\Venda */

// Status e cores de exemplo para vendas
$status = $model->estadoEncomenda->descricao ?? 'N/A';
$statusColor = $model->estadoEncomenda && $model->estadoEncomenda->isFinalState() ? 'green' : 'grey';
?>

<div class="history-order-box border p-3 rounded shadow-sm">
    <!-- Total no canto superior direito -->
    <div class="history-order-total text-end">
        <span>TOTAL:</span> <?= Yii::$app->formatter->asCurrency($model->total) ?>
    </div>

    <!-- Informações do Pedido -->
    <div class="history-order-info">
        <h6>SALE #<?= $model->codigo ?></h6>
        <h3><?= Html::encode($model->getLinhavendas()->count()) ?> ITEMS SOLD</h3>
        <p><span>STATUS: </span><span style="color: <?= $statusColor ?>; font-weight: bold;"><?= Html::encode($status) ?></span></p>
    </div>

    <!-- Botões no canto inferior direito -->
    <div class="history-buttons text-end">
        <?= Html::a('VIEW SALE DETAILS', ['venda/view', 'id' => $model->id], ['class' => 'history-view-details']) ?>
        <?= Html::a('VIEW INVOICE', ['venda/invoice', 'id' => $model->id], ['class' => 'history-view-invoice']) ?>
    </div>
</div>
