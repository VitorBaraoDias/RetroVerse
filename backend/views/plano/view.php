<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \common\models\Plano $model */

$this->title = $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
                'label' => 'IVA (%)', // Rótulo personalizado para a coluna
            ],
            'descricao',
            [
                'attribute' => 'ativo',
                'format' => 'raw', // Exibir HTML se necessário
                'value' => function($model) {
                    return $model->ativo
                        ? Html::tag('span', 'Active', ['class' => 'badge bg-success'])
                        : Html::tag('span', 'Inactive', ['class' => 'badge bg-danger']);
                },
            ],
        ],
    ]) ?>

</div>
