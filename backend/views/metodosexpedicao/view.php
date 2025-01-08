<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->nome;

?>
<div class="metodosexpedicao-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this shipping method?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'nome',
                'label' => 'Name',
            ],
        ],
    ]) ?>

</div>
