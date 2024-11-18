<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\comissao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comissao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comissao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
