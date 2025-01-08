<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->titulo;
\yii\web\YiiAsset::register($this);
?>
<div class="banner-view">
    <?php if ($model->caminhoimagem && file_exists('../../common/uploads/img-banners/' . $model->caminhoimagem)): ?>
        <div class="text-center mb-4">
            <?= Html::img('../../../common/uploads/img-banners/' . $model->caminhoimagem, [
                'alt' => 'Banner Image',
                'class' => 'img-fluid',
                'style' => 'max-width: 100%; height: auto;',
            ]) ?>
        </div>
    <?php else: ?>
        <div class="text-center mb-4">
            <p>No banner image available</p>
        </div>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Title',
                'value' => $model->titulo ?? 'N/A',
            ],
            [
                'label' => 'Description',
                'value' => $model->descricao ?? 'N/A',
            ],
            [
                'label' => 'Button Link',
                'value' => $model->link ?? 'N/A',
            ],
            [
                'label' => 'Button Text',
                'value' => $model->textobotao ?? 'N/A',
            ],
            [
                'label' => 'Active Status',
                'value' => $model->ativo ? 'Active' : 'Inactive',
            ],
        ],
    ]) ?>

    <div class="mt-4">
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data-confirm' => 'Are you sure you want to delete this banner?',
            'data-method' => 'post',
        ]) ?>
    </div>
</div>
