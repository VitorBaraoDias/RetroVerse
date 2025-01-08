<?php

use yii\helpers\Html;

?>

<div class="card h-100">
    <div class="card-body">
        <div class="d-flex align-items-center flex-column">
            <?php
            if ($model->caminhoimagem && file_exists('../../common/uploads/img-banners/' . $model->caminhoimagem)) {
                echo Html::img('../../../common/uploads/img-banners/' . $model->caminhoimagem, [
                    'alt' => 'Banner Image',
                    'class' => 'img-thumbnail',
                    'style' => 'width: 370px; height: 270px; object-fit: cover;',
                ]);
            } else {
                echo Html::tag('div', '', [
                    'class' => 'img-thumbnail',
                    'style' => 'width: 370px; height: 270px; background-color: grey; display: flex; align-items: center; justify-content: center;',
                ]);
            }
            ?>
        </div>
        <hr>
        <h5 class="text-start"><?= Html::encode($model->titulo) ?></h5>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Description:</strong>
            <?= Html::tag('span', $model->descricao, ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Link:</strong>
            <?= Html::tag('span', $model->link, ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Status:</strong>
            <?= $model->ativo
                ? Html::tag('span', 'Active', ['class' => 'badge bg-success'])
                : Html::tag('span', 'Inactive', ['class' => 'badge bg-danger']); ?>
        </p>

    </div>
    <div class="card-footer">
        <?= Html::a('View Details', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary btn-sm w-100']) ?>

        <?= Html::a('Edit', ['update', 'id' => $model->id], [
            'class' => 'btn btn-warning btn-sm w-100 mt-2',
        ]) ?>

        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm w-100 mt-2',
            'data-confirm' => 'Are you sure you want to delete this banner?',
            'data-method' => 'post',
        ]) ?>
    </div>
</div>
