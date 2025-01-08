<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="linhavenda-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idvenda')->textInput() ?>

    <?= $form->field($model, 'idartigo')->textInput() ?>

    <?= $form->field($model, 'idvendedor')->textInput() ?>

    <?= $form->field($model, 'idestadoencomenda')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
