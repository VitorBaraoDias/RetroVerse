<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\Denuncia $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="denuncia-form row card py-4 px-5" style="width: fit-content;">
    <div class="d-flex mt-2 align-items-center justify-content-between gap-2 mb-2">
        <div class="d-flex gap-2 align-items-center">
            <?php if (!empty($artigo->idperfil0->caminhofotoperfil)): ?>
                <img class=" rounded-circle" style="object-fit: cover; width: 60px"
                     src="<?= Yii::getAlias('@web') ?>/uploads/img-profile/<?= $artigo->idperfil0->caminhofotoperfil ?>"
                     alt="Foto de Perfil" height="60">
            <?php else: ?>
                <img class="" src="<?= Yii::getAlias('@web') ?>/img/icon-profile.svg" alt="Profile icon"
                     height="70">
            <?php endif; ?>
            <h2 class="text-uppercase"><strong> <?= $artigo->idperfil0->user->username ?> </strong></h2>
            <div class="d-flex">
                <span><?= $artigo->idperfil0->getAvgRates() ?></span>
                <img src="<?= Yii::getAlias('@web/img/star.svg') ?>" alt="Star Icon" style="height: 20px; margin-left: 10px;">
                <span>(<?= $artigo->idperfil0->getCountRates() ?>)</span>
            </div>
        </div>
    </div>
    <div class="d-flex gap-4">
        <div>
            <?php
            $firstPhoto = $artigo->fotosartigos[0] ?? null;
            $imagePath = Yii::getAlias('@web/uploads/img-artigos/') . ($firstPhoto->caminhofoto ?? '');

            if ($firstPhoto && file_exists(Yii::getAlias('@frontend/web/uploads/img-artigos/') . $firstPhoto->caminhofoto)) {
                echo Html::img($imagePath, [
                    'alt' => 'Article Image',
                    'class' => '',
                    'style' => ' height: 230px; width: 230px; object-fit: cover;',
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
                <span><?= $artigo->tipoartigo ?></span>
                <p style="font-size: 18px; margin: 0px">
                    <strong><?= Html::encode($artigo->nome) ?></strong>
                </p>
            </div>
            <div class="d-flex flex-column h-100 justify-content-between">
                <div class="d-flex gap-2">
                    <h2 style="font-size: 16px"><strong><?= Html::encode($artigo->idmarca0->nome ?? 'Unknown Brand') ?></strong></h2>
                    <h2 style="font-size: 16px"><?= Html::encode($artigo->idcategoria0->nome ?? 'Unknown Category') ?></h2>
                    <h2 style="font-size: 16px"><?= Html::encode($artigo->idtamanho0->tamanho ?? 'Unknown Size') ?></h2>
                </div>
                <div class="d-flex flex-column align-items-start">
                    <h2 style="font-size: 24px">
                        <strong><?= $artigo->getPriceWithComissionFormated() ?></strong>
                    </h2>
                </div>
            </div>
        </div>
    </div>
        <?php $form = ActiveForm::begin([
            'action' => ['denuncia/create', 'id' => $artigo->id],
        ]); ?>
        <div class="input-details mt-3">
            <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('REPORT AD', ['class' => 'btn btn-danger ']) ?>
        </div>
        <?php ActiveForm::end(); ?>
</div>
