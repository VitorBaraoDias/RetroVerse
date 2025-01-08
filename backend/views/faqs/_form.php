<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="faqs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'questao')->textInput(['maxlength' => true])->label("Question") ?>

    <?= $form->field($model, 'resposta')->textInput(['maxlength' => true])->label("Answer") ?>

    <?= $form->field($model, 'categoria')->textInput(['maxlength' => true])->label("Category") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
