<?php

use yii\helpers\Html;

?>
<div class="card h-100">
    <div class="card-body">
        <div class="d-flex align-items-center flex-column">
            <?php

            $artigo = $model->idartigo0;
            $firstPhoto = $artigo->fotosartigos[0] ?? null;
            if ($firstPhoto && file_exists('../../common/uploads/img-artigos/' . $firstPhoto->caminhofoto)) {
                echo Html::img(('../../../common/uploads/img-artigos/') . $firstPhoto->caminhofoto, [
                    'alt' => 'Item Image',
                    'class' => 'img-thumbnail',
                    'style' => 'width: 370px; height: 270px; object-fit: cover;',
                ]);
            } else {
                // Se não houver imagem, exibir uma div cinza
                echo Html::tag('div', '', [
                    'class' => 'img-thumbnail',
                    'style' => 'width: 370px; height: 270px; background-color: grey; display: flex; align-items: center; justify-content: center;',
                ]);
            }
            ?>
        </div>
        <hr>
        <h5 class="text-start">Artigo Denunciado: <?= Html::encode($artigo->nome) ?></h5>
        <hr>

        <p class="text-center">
            <strong>Status:</strong>
            <?= $model->estado ? '<span class="badge bg-success">Resolved</span>' : '<span class="badge bg-warning">Pending</span>' ?>
        </p>
        <hr>
        <p class="text-start"><strong>Descrição da Denúncia:</strong> <?= Html::encode($model->descricao) ?></p>
        <hr>

        <!-- Informações do denunciador -->
        <p class="text-start"><strong>Denunciante:</strong></p>
        <div class="d-flex align-items-center">
            <?php
            $denunciante = $model->iddenunciante0;
            if ($denunciante && file_exists('../../common/uploads/img-profile/' . $denunciante->caminhofotoperfil)) {
                echo Html::img(('../../../common/uploads/img-profile/') . $denunciante->caminhofotoperfil, [
                    'alt' => $denunciante->user->username,
                    'class' => 'rounded-circle',
                    'style' => 'width: 50px; height: 50px; object-fit: cover; margin-right: 10px;',
                ]);
            }
            ?>
            <span>@<?= Html::encode($denunciante->user->username) ?></span>
        </div>
        <hr>

        <!-- Informações do denunciado -->
        <p class="text-start"><strong>Denunciado:</strong></p>
        <div class="d-flex align-items-center">
            <?php
            $denunciado = $model->iddenunciado0; // Relacionamento para acessar o usuário denunciado
            if ($denunciado && file_exists('../../common/uploads/img-profile/' . $denunciado->caminhofotoperfil)) {
                echo Html::img(('../../../common/uploads/img-profile/') . $denunciado->caminhofotoperfil, [
                    'alt' => $denunciado->user->username,
                    'class' => 'rounded-circle',
                    'style' => 'width: 50px; height: 50px; object-fit: cover; margin-right: 10px;',
                ]);
            }
            ?>
            <span>@<?= Html::encode($denunciado->user->username) ?></span>
        </div>
    </div>
    <div class="card-footer">
        <?php if (!$model->estado): ?>
            <!-- Botão para eliminar item (se existir) -->
            <?php if ($model->idartigo && $model->idartigo0->ativo): ?>
                <?= Html::a('Delete Item', ['artigo/delete', 'id' => $model->idartigo], [
                    'class' => 'btn btn-danger btn-sm w-100 mb-2',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>

            <!-- Botão para banir user -->
            <?php if (!$model->estado): ?>
                <?= Html::a('Ban User', ['denuncia/ban-user', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm w-100 mt-2 mb-2',
                    'data-confirm' => 'Are you sure you want to ban this user?',
                    'data-method' => 'post',
                ]) ?>
            <?php else: ?>
                <p class="text-muted">This user has already been banned.</p>
            <?php endif; ?>

            <!-- Botão para marcar como resolvido -->
            <?= Html::a(
                'Mark as Resolved',
                ['denuncia/markasresolved', 'id' => $model->id],
                [
                    'class' => 'btn btn-success btn-sm w-100',
                    'data' => [
                        'confirm' => 'Are you sure you want to mark this report as resolved?',
                    ],
                ]
            ) ?>
        <?php endif; ?>
    </div>
</div>

