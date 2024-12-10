<?php

use yii\helpers\Html;

/* @var $model \common\models\Linhascarrinho */

$precoBase = $model->artigo->precoanuncio;
$porcentagemIVA = Yii::$app->params['iva'] ?? 20; // Ou use $iva->porcentagem se o IVA for específico para este item
$valorIVA = $precoBase * ($porcentagemIVA / 100);
$precoComIVA = $precoBase + $valorIVA;
?>
<div class="w-100 d-flex justify-content-between">
    <div class="d-flex align-items-center gap-4">
        <div>
            <span>Store</span>
            <p style="font-size: 18px">
                <strong><?= Html::encode($model->artigo->nome) ?></strong>
            </p>
            <?php
            $firstPhoto = $model->artigo->fotosartigos[0] ?? null;
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
            <h2 style="font-size: 18px"><strong><?= Html::encode($model->artigo->idmarca0->nome ?? 'Unknown Brand') ?></strong></h2>
            <h2 style="font-size: 18px"><?= Html::encode($model->artigo->idcategoria0->nome ?? 'Unknown Category') ?></h2>
            <h2 style="font-size: 18px"><?= Html::encode($model->artigo->idtamanho0->tamanho ?? 'Unknown Size') ?></h2>
        </div>
    </div>
    <div class="d-flex flex-column justify-content-between">
        <div>
            <div class="d-flex align-items-center gap-2">
                <h1 style="font-size: 30px">
                    <strong><?= Yii::$app->formatter->asCurrency($model->artigo->precoanuncio, 'EUR') ?></strong>
                </h1>
                <h2 style="font-size: 20px">
                    <?= Yii::$app->formatter->asCurrency($precoComIVA, 'EUR') ?>
                </h2>
            </div>
            <p>WITH TAXES</p>
        </div>
    </div>
</div>

