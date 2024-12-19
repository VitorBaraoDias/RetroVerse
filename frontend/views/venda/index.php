<?php

use common\models\Venda;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;



/** @var yii\web\View $this */
/** @var common\models\SearchVenda $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>
<div class="container venda-index">

    <h2 class="text-left fw-bolder" style="font-weight: bold;">ORDER HISTORY</h2>

    <div class="container mt-4">
        <!-- Filtros de Compras/Vendas -->
        <?php
        $tipoVenda = Yii::$app->request->get('VendaSearch')['tipoVenda'] ?? 'purchases';
        $estadoEncomenda = Yii::$app->request->get('VendaSearch')['estadoEncomenda'] ?? null;
        ?>
        <button class="history-button px-4 py-2 <?= $tipoVenda === 'purchases' ? 'active' : '' ?>"
                onclick="location.href='<?= Yii::$app->urlManager->createUrl(['venda/index', 'VendaSearch' => ['tipoVenda' => 'purchases']]) ?>'; setActive(this, 'category')">
            PURCHASES
        </button>
        <button class="history-button px-4 py-2 <?= $tipoVenda === 'sales' ? 'active' : '' ?>"
                onclick="location.href='<?= Yii::$app->urlManager->createUrl(['venda/index', 'VendaSearch' => ['tipoVenda' => 'sales']]) ?>'; setActive(this, 'category')">
            SALES
        </button>
    </div>

    <div class="container mt-4">
        <!-- Filtros de Status da compra/venda -->
        <h5 class="fw-bold mb-3">FILTER BY STATUS</h5>
        <?php
        $estadoEncomenda = Yii::$app->request->get('VendaSearch')['estadoEncomenda'] ?? null;
        ?>
        <button class="history-button px-4 py-2 <?= empty($estadoEncomenda) ? 'active' : '' ?>"
                onclick="location.href='<?= Yii::$app->urlManager->createUrl(['venda/index', 'VendaSearch' => ['tipoVenda' => $tipoVenda]]) ?>'; setActive(this, 'status')">
            ALL ORDERS
        </button>
        <button class="history-button px-4 py-2 <?= $estadoEncomenda === 'Accepted' ? 'active' : '' ?>"
                onclick="location.href='<?= Yii::$app->urlManager->createUrl(['venda/index', 'VendaSearch' => ['tipoVenda' => $tipoVenda, 'estadoEncomenda' => 'Accepted']]) ?>'; setActive(this, 'status')">
            ACCEPTED
        </button>
        <button class="history-button px-4 py-2 <?= $estadoEncomenda === 'Completed' ? 'active' : '' ?>"
                onclick="location.href='<?= Yii::$app->urlManager->createUrl(['venda/index', 'VendaSearch' => ['tipoVenda' => $tipoVenda, 'estadoEncomenda' => 'Completed']]) ?>'; setActive(this, 'status')">
            COMPLETED
        </button>
    </div>

    <!-- Lista de Encomendas -->
    <div class="container mt-4">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => $viewType === 'sales' ? '_sale_order_card' : '_order_card',
            'layout' => '<div class="row">{items}</div>{pager}',
            'itemOptions' =>  $viewType === 'sales' ? ['class' => 'col-md-4 mb-4'] : ['class' => 'col-md-12 mb-4'],
            'pager' => [
                'class' => \yii\bootstrap5\LinkPager::class,
                'options' => ['class' => 'pagination justify-content-center'],
            ],
        ]); ?>
    </div>
</div>

<script>
    function setActive(button, group) {
        let selector = '';

        // Define os seletores para cada grupo
        if (group === 'category') {
            selector = '.container:nth-of-type(1) .history-button';
        } else if (group === 'status') {
            selector = '.container:nth-of-type(2) .history-button';
        }

        // Remove a classe 'active' apenas do grupo selecionado
        const buttons = document.querySelectorAll(selector);
        buttons.forEach(btn => btn.classList.remove('active'));

        // Adiciona a classe 'active' ao botão clicado
        button.classList.add('active');
    }
</script>
