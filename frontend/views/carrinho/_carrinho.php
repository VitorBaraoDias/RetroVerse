<?php

use yii\helpers\Html;

/* @var $model \common\models\Linhascarrinho */



$precoBase = $model->artigo->precoanuncio;
$porcentagemIVA = Yii::$app->params['iva'] ?? 20; // Ou use $iva->porcentagem se o IVA for específico para este item
$valorIVA = $precoBase * ($porcentagemIVA / 100);
$precoComIVA = $precoBase + $valorIVA;

?>
<div class="d-flex align-items-center gap-4">
    <div class="d-flex flex-column">
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
                'alt' => '',
                'class' => 'w-100',
                'style' => 'width: 220px; height: 220px; object-fit: cover;',
            ]);
        } else {
            echo Html::tag('div', '', [
                'class' => 'img-thumbnail',
                'style' => 'width: 350px; height: 220px; background-color: grey; display: flex; align-items: center; justify-content: center;',
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

    <?= Html::a('Remove', ['linhascarrinho/delete', 'id' => $model->id], [
        'class' => 'retroverse-btn active w-100',
        'id' => 'retroverse-btn-active',
        'style' => 'font-size: x-small; gap: 10px',
    ]) ?>
</div>
