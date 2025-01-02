<?php

use yii\helpers\Html;
use common\models\Perfil;



$userId = Yii::$app->user->id;
$perfil = Perfil::findOne(['id' => $userId]);

//verificar se ele tem premium
$isPremium = $perfil ? $perfil->hasActivePremiumPlano() : false;

?>
<div class="d-flex align-items-center gap-4">
    <div class="d-flex flex-column">
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
    <div class="h-100 d-flex flex-column justify-content-between gap-2">
        <div>
            <span><?= $model->artigo->tipoartigo ?></span>
            <p style="font-size: 18px">
                <strong><?= Html::encode($model->artigo->nome) ?></strong>
            </p>
        </div>
        <div>
            <h2 style="font-size: 18px"><strong><?= Html::encode($model->artigo->idmarca0->nome ?? 'Unknown Brand') ?></strong></h2>
            <h2 style="font-size: 18px"><?= Html::encode($model->artigo->idcategoria0->nome ?? 'Unknown Category') ?></h2>
            <h2 style="font-size: 18px"><?= Html::encode($model->artigo->idtamanho0->tamanho ?? 'Unknown Size') ?></h2>
        </div>

    </div>
</div>
<div class="d-flex flex-column justify-content-between">
    <div>
        <div class="d-flex align-items-center gap-2">
            <h1 style="font-size: 30px">
                <strong>
                    <?php

                    echo $isPremium
                        ? Yii::$app->formatter->asCurrency($model->artigo->precoanuncio, 'EUR')
                        : $model->artigo->getPrecoComComissaoFormatado();
                    ?>
                </strong>
            </h1>
            <?php if ($model->artigo->tipoartigo === 'MARKETPLACE'): ?>
                <h2 style="font-size: 20px">
                    <?= Yii::$app->formatter->asCurrency($model->artigo->precoanuncio, 'EUR') ?>
                </h2>
            <?php endif; ?>
        </div>
        <p class="d-flex align-items-center gap-2">
            <?php if ($model->artigo->tipoartigo === 'MARKETPLACE'): ?>
                <?php if ($isPremium): ?>
                    <span style="color:#0000FF;">
                    <img class="pr-2" src="<?= Yii::getAlias('@web') ?>/img/premium-user-verified.svg" alt="">WITHOUT TAXES (PREMIUM)
                </span>
                <?php else: ?>
                    <span>WITH TAXES</span>
                <?php endif; ?>
            <?php else: ?>
                <span>WITHOUT TAXES</span>
            <?php endif; ?>
        </p>
    </div>


    <?= Html::a('Remove', ['linhascarrinho/delete', 'id' => $model->id], [
        'class' => 'retroverse-btn active w-100',
        'id' => 'retroverse-btn-active',
        'style' => 'font-size: x-small; gap: 10px',
    ]) ?>
</div>
