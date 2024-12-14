<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Perfil $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="perfil-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="input-details">
                <?= $form->field($model, 'username')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Enter your username'
                ])->label('Username'); ?>
            </div>
            <div class="input-details">
                <?= $form->field($model, 'descricao')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Enter your description'
                ])->label('Description'); ?>
            </div>
            <?= $form->field($model, 'caminhofotoperfil')->textInput(['maxlength' => true]) ?>
            <div class="input-details">
                <?= $form->field($model, 'morada')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Enter your dress'
                ])->label('Location'); ?>
            </div>
        </div>
    </div>
    <div class="form-group d-flex justify-content-end mt-4">
        <?= Html::submitButton('CONFIRM', ['class' => 'btn retroverse-btn active w-auto px-5 py-2', 'id' => "retroverse-btn-active"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
