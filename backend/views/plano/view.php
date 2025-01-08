<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->descricao;

?>
<div class="plano-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'precomensal',
                'label' => 'Monthly Payment',
            ],
            [
                'attribute' => 'idiva',
                'value' => function ($model) {
                    return $model->iva ? $model->iva->percentagem . '%' : null;
                },
                'label' => 'IVA (%)',
            ],
            'descricao',
            [
                'attribute' => 'ativo',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->ativo
                        ? Html::tag('span', 'Active', ['class' => 'badge bg-success'])
                        : Html::tag('span', 'Inactive', ['class' => 'badge bg-danger']);
                },
            ],
        ],
    ]) ?>

</div>
