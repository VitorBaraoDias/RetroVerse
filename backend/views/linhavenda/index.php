<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;


$this->title = 'Store Orders';
?>
<div class="linhavenda-index">
    <div class="row mb-3">
        <!-- Filtros -->
        <div class="col-md-4">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'], // Pode ser alterado para o controlador correto
            ]); ?>

            <!-- Filtro de estado de encomenda -->
            <?= $form->field($searchModel, 'statusFilter')->dropDownList(
                [
                    'accepted' => 'Accepted',
                    'completed' => 'Completed',
                ],
                ['prompt' => 'Select Status']
            )->label('Filter Order by Status') ?>

            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <!-- Filtro por Mês -->
        <div class="col-md-4">
            <?php $monthForm = ActiveForm::begin([
                'method' => 'get',
                'action' => ['linhavenda/report'],
            ]); ?>

            <div class="form-group">
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


            <div class="form-group">
                <?= Html::submitButton('Generate Month Report', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>




<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_artigo',
    'layout' => '<div class="row">{items}</div>{pager}',
    'options' => ['class' => 'list-view'],
    'itemOptions' => [
        'class' => 'col-md-4 mb-44' // Definindo o layout de coluna
    ],
]) ?>
</div>