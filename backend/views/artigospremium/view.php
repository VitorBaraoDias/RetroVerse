<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \common\models\Artigospremium $model */

$this->title = "Artigo Premium - " . $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="artigospremium-view">

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
                'attribute' => 'id',
                'value' => $model->artigo->nome,
                'label' => 'Artigo',
            ],
            [
                'attribute' => 'idPlano',
                'value' => $model->plano->descricao,
                'label' => 'Plano Associado', // Label personalizado
            ],
        ],
    ]) ?>

</div>
