<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="iva-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'percentagem')->textInput() ?>

    <?= $form->field($model, 'emvigor')->checkbox([
        'label' => 'Active',
        'uncheck' => 0,
        'checked' => 1,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
