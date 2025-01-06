<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \common\models\Categoriaartigo $model */

$this->title = $model->nome;
?>
<div class="categoriaartigo-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
                'attribute' => 'nome',
                'label' => 'Name',
            ],
            [
                'attribute' => 'ativo',
                'label' => 'Active Status',
                'format' => 'raw', // Exibir HTML se necessário
                'value' => function($model) {
                    return $model->ativo
                        ? Html::tag('span', 'Active', ['class' => 'badge bg-success'])
                        : Html::tag('span', 'Inactive', ['class' => 'badge bg-danger']);
                },
                'filter' => [
                    1 => 'Active',         // Opção para Ativo
                    0 => 'Inactive',       // Opção para Inativo
                ],
                'filterInputOptions' => [
                    'class' => 'form-control', // Estilo do dropdown
                    'prompt' => 'Select Status' // Texto do prompt no dropdown
                ]
            ],
        ],
    ]) ?>

</div>
