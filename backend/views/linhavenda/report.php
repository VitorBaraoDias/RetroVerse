<?php

use yii\helpers\Html;
use yii\widgets\ListView;
/** @var yii\web\View $this */
/** @var array $orders */
/** @var string $month */

$this->title = "Sales Report - Month " . date('F', mktime(0, 0, 0, $month, 10));  // Mês por extenso
?>

<div class="relatorio-vendas">
    <p>
        <strong>Month Selected: </strong> <?= Html::encode(date('F', mktime(0, 0, 0, $month, 10))) ?>
    </p>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Date of Sale</th>
            <th>Client</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Size</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,  // Passa o DataProvider
            'itemView' => '_report_items',  // Define a view parcial para cada item
            'layout' => '{items}{pager}',  // Exibe os itens seguidos da paginação
            'options' => ['class' => 'list-view'],
            'pager' => [
                'class' => \yii\bootstrap5\LinkPager::class,
                'options' => ['class' => 'pagination justify-content-center'],
            ],
        ]) ?>
        </tbody>
    </table>

</div>
