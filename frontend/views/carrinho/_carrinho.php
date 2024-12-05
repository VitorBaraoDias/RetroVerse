<?php

use yii\helpers\Html;

/* @var $model \common\models\Linhascarrinho */

?>
<div class="d-flex align-items-center gap-4">
    <div>
        <span>Store</span>
        <p style="font-size: 18px">
            <strong><?= Html::encode($model->artigo->nome) ?></strong>
        </p>
        <?php
        $firstPhoto = $model->fotosartigos[0] ?? null;
        if ($firstPhoto && file_exists('../../common/uploads/img-artigos/' . $firstPhoto->caminhofoto)) {
            echo Html::img(('../../common/uploads/img-artigos/'). $firstPhoto->caminhofoto, [
                'alt' => 'Article Image',
                'class' => 'w-100',
                'style' => 'width: 230px; height: 200px; object-fit: cover;',
            ]);
        } else {
            // Se não houver imagem, exibir uma div cinza
            echo Html::tag('div', '', [
                'class' => 'img-thumbnail',
                'style' => 'width: 230px; height: 200px; background-color: grey; display: flex; align-items: center; justify-content: center;',
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
                <?= Yii::$app->formatter->asCurrency($model->artigo->precoanuncio * 1.2, 'EUR') ?>
            </h2>
        </div>
        <p>WITH TAXES</p>
    </div>
    <?= Html::a('Remove', ['carrinho/delete', 'id' => $model->id], [
        'class' => 'retroverse-btn active w-100',
        'id' => 'retroverse-btn-active',
        'style' => 'font-size: x-small; gap: 10px',
    ]) ?>
</div>
