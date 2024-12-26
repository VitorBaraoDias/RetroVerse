<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Estadoencomenda;

/* @var $model common\models\Linhavenda */

$precoBase = $model->idartigo0->precoanuncio;  // Alterado para usar idartigo0 em vez de artigo
$porcentagemIVA = Yii::$app->params['iva'] ?? 20; // Ou use $iva->porcentagem se o IVA for específico para este item
$valorIVA = $precoBase * ($porcentagemIVA / 100);
$precoComIVA = $precoBase + $valorIVA;
?>

<div class="position-relative d-flex flex-column align-items-center gap-4" style="padding-bottom: 20px;"> <!-- Adicionado padding-bottom para evitar sobreposição do botão -->
    <div class="d-flex gap-4">
        <div>

            <?php
            $firstPhoto = $model->idartigo0->fotosartigos[0] ?? null;
            $imagePath = Yii::getAlias('@web/uploads/img-artigos/') . ($firstPhoto->caminhofoto ?? '');

            if ($firstPhoto && file_exists(Yii::getAlias('@frontend/web/uploads/img-artigos/') . $firstPhoto->caminhofoto)) {
                echo Html::img($imagePath, [
                    'alt' => 'Article Image',
                    'class' => 'w-100',
                    'style' => ' height: 230px; object-fit: cover;',
                ]);
            } else {
                echo Html::tag('div', '', [
                    'class' => 'img-thumbnail',
                    'style' => 'width: 240px; height: 270px; background-color: grey; display: flex; align-items: center; justify-content: center;',
                ]);
            }
            ?>
        </div>
        <div class="d-flex flex-column">
            <div>
                <span><?= $model->idartigo0->tipoartigo ?></span>
                <p style="font-size: 18px; margin: 0px">
                    <strong><?= Html::encode($model->idartigo0->nome) ?></strong>
                </p>
            </div>
            <div class="d-flex flex-column h-100 justify-content-between">
                <div class="d-flex gap-2">
                    <h2 style="font-size: 16px"><strong><?= Html::encode($model->idartigo0->idmarca0->nome ?? 'Unknown Brand') ?></strong></h2>
                    <h2 style="font-size: 16px"><?= Html::encode($model->idartigo0->idcategoria0->nome ?? 'Unknown Category') ?></h2>
                    <h2 style="font-size: 16px"><?= Html::encode($model->idartigo0->idtamanho0->tamanho ?? 'Unknown Size') ?></h2>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <h2 style="font-size: 24px">
                        <strong><?= Yii::$app->formatter->asCurrency($model->idartigo0->precoanuncio, 'EUR') ?></strong>
                    </h2>
                    <h3 style="font-size: 18px">
                        <?= Yii::$app->formatter->asCurrency($precoComIVA, 'EUR') ?>
                    </h3>
                </div>
            </div>





        <!-- Adicionar o botão ao canto inferior direito -->
    </div>
    </div>

    <?php
    $estadoAntesDoUltimo = Estadoencomenda::isBeforeLastState();

    if ($estadoAntesDoUltimo && $model->idestadoencomenda == $estadoAntesDoUltimo->id && Yii::$app->user->id === $model->idvenda0->idcomprador): ?>
            <?= Html::a(
                'I´VE ALREADY RECEIVED THIS ITEM',
                ['linhavenda/orderreceived', 'id' => $model->id],
                [
                    'class' => 'history-view-details ml-auto mr-4',
                    'style' => 'font-size: small;',
                    'data-confirm' => 'Are you sure you want to confirm that you received this item?',
                ]
            ) ?>
    <?php endif; ?>
    <?php if ($model->idestadoencomenda0->isFinalState() && $model->idartigo0->tipoartigo !== 'LOJA'): ?>
        <?= Html::a(
            '<span>RATE</span> <img height="20px" src="' . Yii::getAlias('@web/img/star.svg') . '" alt="Star Icon">',
            ['avaliacao/create', 'id' => $model->id], // Passa o ID da linhavenda como parâmetro
            [
                'class' => 'history-view-details ml-auto mr-',
                'style' => 'font-size: x-small; gap: 10px',
                'encode' => false, // Permitir HTML no conteúdo
            ]
        ) ?>
    <?php endif; ?>



