<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="avaliacao-form row">

    <div class="col-md-6">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'descricao')->textInput() ?>

        <?= $form->field($model, 'escala')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'idremetente')->textInput() ?>

        <?= $form->field($model, 'iddestinatario')->textInput() ?>


        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
        <?php if (!empty($linhaVenda->idvendedor->caminhofotoperfil)): ?>
            <img class="col-md-3 rounded-circle mb-4" style="object-fit: cover"
                 src="<?= Yii::getAlias('@web') ?>/uploads/img-profile/<?= $linhaVenda->idvendedor->caminhofotoperfil ?>" alt="Foto de Perfil" height="140">
        <?php else: ?>
            <img class="col-md-3 mb-4" src="<?= Yii::getAlias('@web') ?>/img/icon-profile.svg" alt="Ícone de Perfil" height="140">
        <?php endif; ?>
        <div class="position-relative d-flex flex-column align-items-center gap-4" style="padding-bottom: 20px;"> <!-- Adicionado padding-bottom para evitar sobreposição do botão -->
            <div class="d-flex gap-4">
                <div>
                    <?php
                    $firstPhoto = $linhaVenda->idartigo0->fotosartigos[0] ?? null;
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


