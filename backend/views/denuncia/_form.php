<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="denuncia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'iddenunciante')->textInput() ?>

    <?= $form->field($model, 'iddenunciado')->textInput() ?>

    <?= $form->field($model, 'idartigo')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
