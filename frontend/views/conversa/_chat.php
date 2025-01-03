<?php if (Yii::$app->user->identity && Yii::$app->user->identity->id === $model->iduser): ?>
    <div class="chat outgoing" data-index="<?= $model->id ?>">
        <div class="details" id="message-<?= $model->id ?>">
            <?php if ($model->tipo === 'TEXTO' && $model->mensagem): ?>
                <!-- Exibe a mensagem de texto -->
                <p><?= htmlspecialchars($model->mensagem->descricao) ?></p>
            <?php elseif ($model->tipo === 'PROPOSTA' && $model->mensagemproposta): ?>
                <!-- Exibe a mensagem de proposta -->
                <div class="d-flex flex-column justify-content-center align-items-center cardProposta p-2" data-index="<?= $model->mensagemproposta->id ?>">
                    <div class="d-flex gap-2">
                        <span class="font-weight-bold">
                            <?= number_format($model->mensagemproposta->preco, 2, ',', '.') ?>€
                        </span>
                        <div class="position-relative">
                            <span>
                                <?= number_format($model->mensagemproposta->artigo->precoanuncio, 2, ',', '.') ?>€
                            </span>
                            <img src="<?= Yii::getAlias('@web') ?>/img/dividerPropose.svg" alt="" style="position: absolute; right: 3px; top: 11px; height: 3px;">
                        </div>
                    </div>
                    <?php if ($model->mensagemproposta->estado === 0): ?>
                        <span class="text-warning status">Pendente</span>
                    <?php elseif ($model->mensagemproposta->estado === 1): ?>
                        <span class="text-danger status">Recusado</span>
                    <?php elseif ($model->mensagemproposta->estado === 2): ?>
                        <div>
                            <span class="text-success text-xs status">accept</span>
                            <a class="btn retroverse-btn active w-auto px-3 py-0 rounded-3 text-white" id="retroverse-btn-active" href="<?= \yii\helpers\Url::to(['carrinho/create', 'id' => $model->chat->idartigo]) ?>">ADD</a>
                        </div>
                    <?php else: ?>
                        <span class="text-muted">Estado desconhecido</span>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>Mensagem inválida ou tipo não reconhecido.</p>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="chat incoming" data-index="<?= $model->id ?>">
        <div class="details" id="message-<?= $model->id ?>">
            <?php if ($model->tipo === 'TEXTO' && $model->mensagem): ?>
                <!-- Exibe a mensagem de texto -->
                <p><?= htmlspecialchars($model->mensagem->descricao) ?></p>
            <?php elseif ($model->tipo === 'PROPOSTA' && $model->mensagemproposta): ?>
                <!-- Exibe a mensagem de proposta -->
                <div class="d-flex flex-column justify-content-center align-items-center p-2 propostaEsq" data-index="<?= $model->mensagemproposta->id ?>">
                    <div class="d-flex gap-2">
                        <span class="font-weight-bold">
                            <?= number_format($model->mensagemproposta->preco, 2, ',', '.') ?>€
                        </span>
                        <div class="position-relative">
                            <span>
                                <?= number_format($model->mensagemproposta->artigo->precoanuncio, 2, ',', '.') ?>€
                            </span>
                            <img src="<?= Yii::getAlias('@web') ?>/img/dividerPropose.svg" alt="" style="position: absolute; right: 3px; top: 11px; height: 3px;">
                        </div>
                    </div>
                    <?php if ($model->mensagemproposta->estado === 0): ?>
                        <div>
                            <a class="btn retroverse-btn active w-auto px-3 py-0 rounded-3 text-white" id="retroverse-btn-active" href="<?= \yii\helpers\Url::to(['mensagemproposta/update', 'id' => $model->mensagemproposta->id, 'state' => 1]) ?>">x</a>
                            <a class="btn retroverse-btn active w-auto px-3 py-0 rounded-3 text-white" id="retroverse-btn-active" href="<?= \yii\helpers\Url::to(['mensagemproposta/update', 'id' => $model->mensagemproposta->id, 'state' => 2]) ?>">accept</a>
                        </div>
                    <?php elseif ($model->mensagemproposta->estado === 1): ?>
                        <span class="text-danger status">Recusado</span>
                    <?php elseif ($model->mensagemproposta->estado === 2): ?>
                        <span class="text-success status">accept</span>
                    <?php else: ?>
                        <span class="text-muted status">Estado desconhecido</span>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>Mensagem inválida ou tipo não reconhecido.</p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
