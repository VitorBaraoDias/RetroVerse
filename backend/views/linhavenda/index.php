<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$this->title = 'Store Orders';
?>
<div class="linhavenda-index">
    <div class="row">
        <!-- Filtros -->
        <div class="col-md-6">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'],
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <!-- Filtro de estado da encomenda -->
                    <?= $form->field($searchModel, 'statusFilter')->dropDownList(
                        [
                            'accepted' => 'Accepted',
                            'completed' => 'Completed',
                        ],
                        ['prompt' => 'Select Status']
                    )->label('Filter Order by Status') ?>
                </div>

                <div class="col-md-6">
                    <!-- Novo campo de pesquisa por Order Number -->
                    <?= $form->field($searchModel, 'orderNumber')->textInput([
                        'placeholder' => 'Enter Order Number'
                    ])->label('Search by Order Number') ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <!-- Filtro por Mês -->
        <div class="col-md-6">
            <?php $monthForm = ActiveForm::begin([
                'method' => 'get',
                'action' => ['linhavenda/report'],
            ]); ?>

            <div class="form-group d-flex">
                <div class="flex-grow-1 mr-3">
                    <?= Html::label('Month:', 'month', ['class' => 'control-label']) ?>
                    <?= Html::dropDownList('month', Yii::$app->request->get('month'), [
                        '01' => 'January',
                        '02' => 'February',
                        '03' => 'March',
                        '04' => 'April',
                        '05' => 'May',
                        '06' => 'June',
                        '07' => 'July',
                        '08' => 'August',
                        '09' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December',
                    ], ['prompt' => 'All months', 'class' => 'form-control']) ?>
                </div>

                <div class="d-flex flex-column align-items-end justify-content-end">
                    <?= Html::submitButton('Generate Month Report', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>

<!-- GRID VIEW -->
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'idvenda0.codigo',
            'label' => 'Order Number',
            'value' => function ($model) {
                return '#' . $model->idvenda0->codigo;
            },
            'contentOptions' => ['class' => 'text-primary']
        ],

        [
            'attribute' => 'idartigo0.nome',
            'label' => 'Article',
            'value' => 'idartigo0.nome',
        ],

        [
            'attribute' => 'idestadoencomenda0.descricao',
            'label' => 'Status',
            'contentOptions' => function ($model) {
                return ['style' => 'color:' . ($model->idestadoencomenda0->isFinalState() ? 'green' : 'grey')];
            },
        ],

        [
            'attribute' => 'idvenda0.datavenda',
            'label' => 'Date of Sale',
            'format' => ['date', 'php:d-m-Y'],
        ],

        [
            'attribute' => 'idvenda0.morada',
            'label' => 'Buyer Address',
            'value' => 'idvenda0.morada',
        ],

        [
            'attribute' => 'idartigo0.precoanuncio',
            'label' => 'Price (€)',
            'value' => function ($model) {
                return number_format($model->idartigo0->precoanuncio, 2) . '€';
            },
        ],

        [
            'attribute' => 'idartigo0.idtamanho0.tamanho',
            'label' => 'Size',
            'value' => 'idartigo0.idtamanho0.tamanho',
        ],

        [
            'attribute' => 'idartigo0.idmarca0.nome',
            'label' => 'Brand',
            'value' => 'idartigo0.idmarca0.nome',
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{ship}',
            'buttons' => [
                'ship' => function ($url, $model, $key) {
                    if ($model->idestadoencomenda0->isFirstState()) {
                        return Html::a('ORDER ALREADY SHIPPED', ['linhavenda/ordersent', 'id' => $model->id], [
                            'class' => 'btn btn-primary btn-sm',
                            'data-confirm' => 'Are you sure you want to mark this item as sent?',
                        ]);
                    }
                    return '';
                },
            ],
        ],
    ],
]); ?>
</div>
