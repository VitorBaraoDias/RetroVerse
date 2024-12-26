<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Estadoencomenda;

/* @var $model common\models\Linhavenda */

$precoBase = $model->idartigo0->precoanuncio;
$porcentagemIVA = Yii::$app->params['iva'] ?? 20;
$valorIVA = $precoBase * ($porcentagemIVA / 100);
$precoComIVA = $precoBase + $valorIVA;
?>

<div class="position-relative d-flex align-items-center gap-4" style="padding-bottom: 60px;">
    <div>
        <span><?= Html::encode($model->idartigo0->tipoartigo) ?></span>
        <p style="font-size: 18px">
            <strong><?= Html::encode($model->idartigo0->nome) ?></strong>
        </p>
        <?php
        $firstPhoto = $model->idartigo0->fotosartigos[0] ?? null;
        $imagePath = Yii::getAlias('@web/uploads/img-artigos/') . ($firstPhoto->caminhofoto ?? '');

        if ($firstPhoto && file_exists(Yii::getAlias('@frontend/web/uploads/img-artigos/') . $firstPhoto->caminhofoto)) {
            echo Html::img($imagePath, [
                'alt' => 'Article Image',
                'class' => 'w-100',
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
    <div class="d-flex flex-column gap-2">
        <h2 style="font-size: 18px"><strong><?= Html::encode($model->idartigo0->idmarca0->nome ?? 'Unknown Brand') ?></strong></h2>
        <h2 style="font-size: 18px"><?= Html::encode($model->idartigo0->idcategoria0->nome ?? 'Unknown Category') ?></h2>
        <h2 style="font-size: 18px"><?= Html::encode($model->idartigo0->idtamanho0->tamanho ?? 'Unknown Size') ?></h2>
    </div>

    <!-- Preços mantidos -->
    <div class="position-absolute" style="right: 10px; top: 10px;">
        <h1 style="font-size: 30px">
            <strong><?= Yii::$app->formatter->asCurrency($model->idartigo0->precoanuncio, 'EUR') ?></strong>
        </h1>
        <h2 style="font-size: 20px">
            <?= Yii::$app->formatter->asCurrency($precoComIVA, 'EUR') ?>
        </h2>
    </div>

    <!-- Adicionar o botão ao canto inferior direito -->
    <?php
    $estadoAntesDoUltimo = Estadoencomenda::isBeforeLastState();

    if ($estadoAntesDoUltimo && $model->idestadoencomenda == $estadoAntesDoUltimo->id && Yii::$app->user->id === $model->idvenda0->idcomprador): ?>
        <div class="position-absolute" style="bottom: 10px; right: 10px;">
            <?= Html::a(
                'I´VE ALREADY RECEIVED THIS ITEM',
                ['linhavenda/orderreceived', 'id' => $model->id],
                [
                    'class' => 'history-view-details',
                    'style' => 'font-size: small;',
                    'data-confirm' => 'Are you sure you want to confirm that you received this item?',
                ]
            ) ?>
        </div>
    <?php endif; ?>
</div>


