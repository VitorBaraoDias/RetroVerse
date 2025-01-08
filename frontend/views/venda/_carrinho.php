<?php

use yii\helpers\Html;
use common\models\Perfil;


$userId = Yii::$app->user->id;
$perfil = Perfil::findOne(['id' => $userId]);

//verificar se ele tem premium
$isPremium = $perfil ? $perfil->hasActivePremiumPlano() : false;


?>
<div class="w-100 d-flex justify-content-between">
    <div class="d-flex align-items-center gap-4">
        <div>

            <?php
            $firstPhoto = $model->artigo->fotosartigos[0] ?? null;
            $imagePath = Yii::getAlias('@web/uploads/img-artigos/') . ($firstPhoto->caminhofoto ?? '');

            if ($firstPhoto && file_exists(Yii::getAlias('@frontend/web/uploads/img-artigos/') . $firstPhoto->caminhofoto)) {
                echo Html::img($imagePath, [
                    'alt' => 'Article Image',
                    'style' => 'width: 250px; height: 250px; object-fit: cover;',
                ]);
            } else {
                echo Html::tag('div', '', [
                    'class' => 'img-thumbnail',
                    'style' => 'width: 250px; height: 250px; background-color: grey; display: flex; align-items: center; justify-content: center;',
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
                <?php if ($model->artigo->tipoartigo === 'MARKETPLACE'): ?>
                    <h1 style="font-size: 30px">
                        <strong>
                            <?= $isPremium
                                ? Yii::$app->formatter->asCurrency($model->artigo->getPriceWithProposalIfExist(), 'EUR')
                                : '€' . $model->artigo->getPriceWithComissionFormated();
                            ?>
                        </strong>
                    </h1>
                <?php endif; ?>
                <h2 style="font-size: 20px">
                    <?= $model->artigo->getPriceWithProposalIfExist() . " EUR"?>
                </h2>
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
    </div>

</div>

