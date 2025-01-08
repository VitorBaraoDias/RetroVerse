<?php

use yii\helpers\Html;

?>
<div class="card h-100">
    <div class="card-body">
        <div class="d-flex align-items-center flex-column">
            <?php
            $firstPhoto = $model->fotosartigos[0] ?? null;
            if ($firstPhoto && file_exists('../../common/uploads/img-artigos/' . $firstPhoto->caminhofoto)) {
                echo Html::img(('../../../common/uploads/img-artigos/'). $firstPhoto->caminhofoto, [
                    'alt' => 'Item Image',
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
        <h5 class="text-start"><?= Html::encode($model->nome) ?></h5>
        <hr>

        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Section:</strong>
            <?= Html::tag('span', $model->tipoartigo, ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Price:</strong>
            <?= Html::tag('span', number_format($model->precoanuncio, 2) . '€', ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Size:</strong>
            <?= Html::tag('span', $model->idtamanho0->tamanho, ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Brand:</strong>
            <?= Html::tag('span', $model->idmarca0->nome, ['class' => 'text-primary']) ?>
        </p>

    </div>
    <div class="card-footer">
        <?= Html::a('View Details', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary btn-sm w-100']) ?>

        <?= Html::a('Edit', ['artigo/update', 'id' => $model->id], [
            'class' => 'btn btn-warning btn-sm w-100 mt-2',
        ]) ?>

        <?php if ($model->artigospremium === null && $model->tipoartigo !== 'MARKETPLACE'): ?>
            <?= Html::a('Promove to Premium Item', ['artigospremium/create', 'id' => $model->id], [
                'class' => 'btn btn-success btn-sm w-100 mt-2',
            ]) ?>
        <?php elseif ($model->tipoartigo !== 'MARKETPLACE'): ?>
            <?= Html::a('Remove from Premium Items', ['artigospremium/delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm w-100 mt-2',
                'data-confirm' => 'Are you sure you want to remove this item from Premium?',
                'data-method' => 'post',
            ]) ?>
        <?php endif; ?>



        <?= Html::a('Delete', ['artigo/delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm w-100 mt-2',
            'data-confirm' => 'Tem certeza de que deseja excluir este artigo?',
            'data-method' => 'post',
        ]) ?>
    </div>
</div>
