<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model common\models\Linhavenda */

$precoBase = $model->idartigo0->precoanuncio;  // Alterado para usar idartigo0 em vez de artigo
$porcentagemIVA = Yii::$app->params['iva'] ?? 20; // Ou use $iva->porcentagem se o IVA for específico para este item
$valorIVA = $precoBase * ($porcentagemIVA / 100);
$precoComIVA = $precoBase + $valorIVA;
?>

<div class="d-flex align-items-center gap-4">
    <div>
        <span>Store</span>
        <p style="font-size: 18px">
            <strong><?= Html::encode($model->idartigo0->nome) ?></strong>  <!-- Alterado para usar idartigo0 -->
        </p>
        <?php
        $firstPhoto = $model->idartigo0->fotosartigos[0] ?? null;  // Alterado para usar idartigo0
        // Caminho para a imagem no frontend
        $imagePath = Yii::getAlias('@web/uploads/img-artigos/') . ($firstPhoto->caminhofoto ?? '');

        if ($firstPhoto && file_exists(Yii::getAlias('@frontend/web/uploads/img-artigos/') . $firstPhoto->caminhofoto)) {
            // Renderiza a imagem
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
        <h2 style="font-size: 18px"><strong><?= Html::encode($model->idartigo0->idmarca0->nome ?? 'Unknown Brand') ?></strong></h2>  <!-- Alterado para usar idartigo0 -->
        <h2 style="font-size: 18px"><?= Html::encode($model->idartigo0->idcategoria0->nome ?? 'Unknown Category') ?></h2>  <!-- Alterado para usar idartigo0 -->
        <h2 style="font-size: 18px"><?= Html::encode($model->idartigo0->idtamanho0->tamanho ?? 'Unknown Size') ?></h2>  <!-- Alterado para usar idartigo0 -->
    </div>
</div>

<div class="d-flex flex-column align-items-end" style="position: absolute; right: 10px; top: 10px;">
<h1 style="font-size: 30px">
    <strong><?= Yii::$app->formatter->asCurrency($model->idartigo0->precoanuncio, 'EUR') ?></strong>
</h1>
<h2 style="font-size: 20px">
    <?= Yii::$app->formatter->asCurrency($precoComIVA, 'EUR') ?>
</h2>
</div>

