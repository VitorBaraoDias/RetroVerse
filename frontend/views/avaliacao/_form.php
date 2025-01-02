<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\Avaliacao $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="avaliacao-form row">

    <div class="col-md-6 d-flex align-items-center" style="width: 100%;"> <!-- Coluna do formulário -->
        <?php $form = ActiveForm::begin([
            'action' => ['avaliacao/create', 'id' => $linhaVenda->id],
            'options' => ['style' => 'width: 100%;'], // Define largura total do formulário
        ]); ?>
        <h2 class="text-center mb-5 text-uppercase"><strong>RATE: <?=$linhaVenda->idvendedor0->user->username?></strong></h2>

        <div class="input-details">
        <?= $form->field($model, 'descricao')->textInput() ?>
        </div>

        <div class="input-details">
        <?= $form->field($model, 'escala')->textInput(['type' => 'number', 'min' => 0, 'max' => 5]) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(
                '<span>Rate</span> <img src="' . Yii::getAlias('@web/img/star.svg') . '" alt="Star Icon" style="height: 20px; margin-left: 10px;">',
                [
                    'class' => 'btn retroverse-btn active w-100 mt-3 px-5 py-2 rounded-0',
                    'id' => 'retroverse-btn-active',
                    'encode' => false, // Permite HTML no conteúdo do botão
                ]
            ) ?>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
        <div class="position-relative d-flex flex-column align-items-center gap-4" style="padding-bottom: 20px;">
            <div class="d-flex gap-4 justify-content-between align-items-start card w-100">
                <div class="d-flex gap-3 align-items-center">
                    <?php
                    if (!empty($linhaVenda->idvendedor0->caminhoperfil)): ?>
                        <img class="rounded-circle mb-4" style="object-fit: cover; height: 40px; width: 40px"
                             src="<?= Yii::getAlias('@web') ?>/uploads/img-profile/<?= $linhaVenda->idvendedor0->caminhoperfil ?>" alt="Foto de Perfil">
                    <?php else: ?>
                        <img src="<?= Yii::getAlias('@web') ?>/img/icon-profile.svg" alt="Ícone de Perfil" height="40">
                    <?php endif; ?>
                    <div class="d-flex align-items-center">
                        <h2 class="mr-2"> <strong><?= $linhaVenda->idvendedor0->user->username ?></strong></h2>
                        <span><?= $linhaVenda->idvendedor0->getAvgRates() ?></span>
                        <img src="<?= Yii::getAlias('@web/img/star.svg') ?>" alt="Star Icon" style="height: 20px; margin-left: 10px;">
                        <span>(<?= $linhaVenda->idvendedor0->getCountRates() ?>)</span>
                    </div>
                </div>
            </div><!-- Adicionado padding-bottom para evitar sobreposição do botão -->
            <div class="d-flex gap-4">
                <div>
                    <?php
                    $firstPhoto = $linhaVenda->idartigo0->fotosartigos[0] ?? null;
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
                        <span><?= $linhaVenda->idartigo0->tipoartigo ?></span>
                        <p style="font-size: 18px; margin: 0px">
                            <strong><?= Html::encode($linhaVenda->idartigo0->nome) ?></strong>
                        </p>
                    </div>
                    <div class="d-flex flex-column h-100 justify-content-between">
                        <div class="d-flex gap-2">
                            <h2 style="font-size: 16px"><strong><?= Html::encode($linhaVenda->idartigo0->idmarca0->nome ?? 'Unknown Brand') ?></strong></h2>
                            <h2 style="font-size: 16px"><?= Html::encode($linhaVenda->idartigo0->idcategoria0->nome ?? 'Unknown Category') ?></h2>
                            <h2 style="font-size: 16px"><?= Html::encode($linhaVenda->idartigo0->idtamanho0->tamanho ?? 'Unknown Size') ?></h2>
                        </div>
                        <div class="d-flex flex-column align-items-start">
                            <h2 style="font-size: 24px">
                                <strong><?= $linhaVenda->idartigo0->getPrecoComComissaoFormatado() ?></strong>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


