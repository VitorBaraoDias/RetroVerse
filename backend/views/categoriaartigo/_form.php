<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="categoriaartigo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true])->label("Name") ?>

    <?= $form->field($model, 'ativo')->checkbox([
        'label' => 'Active',
        'checked' => $model->ativo ? true : false,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
