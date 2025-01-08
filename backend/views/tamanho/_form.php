<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="tamanho-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tamanho')->textInput(['maxlength' => true])->label("Size") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
