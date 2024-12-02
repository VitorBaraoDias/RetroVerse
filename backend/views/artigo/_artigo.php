<?php

use yii\helpers\Html;

?>
<div class="card h-100">
    <div class="card-body">
        <div class="d-flex align-items-center flex-column">
            <?php
            // Exibir a primeira foto do artigo, se disponível
            $firstPhoto = $model->fotosartigos[0] ?? null;
            if ($firstPhoto && file_exists('../../common/uploads/img-artigos/' . $firstPhoto->caminhofoto)) {
                echo Html::img(('../../../common/uploads/img-artigos/'). $firstPhoto->caminhofoto, [
                    'alt' => 'Article Image',
                    'class' => 'img-thumbnail',
                    'style' => 'width: 370px; height: 270px; object-fit: cover;',
                ]);
            } else {
                // Se não houver imagem, exibir uma div cinza
                echo Html::tag('div', '', [
                    'class' => 'img-thumbnail',
                    'style' => 'width: 150px; height: 150px; background-color: grey; display: flex; align-items: center; justify-content: center;',
                ]);
            }
            ?>
        </div>
        <hr>
        <!-- Nome do artigo -->
        <h5 class="text-start"><?= Html::encode($model->nome) ?></h5>
        <!-- Preço do artigo -->
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Preço:</strong>
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
        <!-- Botões de edição e exclusão -->
        <?= Html::a('Detalhes', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary btn-sm w-100']) ?>

        <?= Html::a('Editar', ['artigo/update', 'id' => $model->id], [
            'class' => 'btn btn-warning btn-sm w-100 mt-2',
        ]) ?>

        <!-- Verifique se o artigo já é premium -->
        <?php if ($model->artigospremium === null): ?>
            <!-- Exibir botão para promover o artigo a premium -->
            <?= Html::a('Atribuir como artigo premium', ['artigospremium/create', 'id' => $model->id], [
                'class' => 'btn btn-success btn-sm w-100 mt-2',
            ]) ?>
        <?php else: ?>
            <!-- Exibir botão para remover de artigo premium -->
            <?= Html::a('Remover de artigos premium', ['artigospremium/delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm w-100 mt-2',
                'data-confirm' => 'Tem certeza que deseja remover este artigo dos artigos premium?',
                'data-method' => 'post',
            ]) ?>
        <?php endif; ?>


        <?= Html::a('Excluir', ['artigo/delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm w-100 mt-2',
            'data-confirm' => 'Tem certeza de que deseja excluir este artigo?',
            'data-method' => 'post',
        ]) ?>
    </div>
</div>
