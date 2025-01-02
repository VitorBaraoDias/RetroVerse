<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\Marca $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="marca-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true])->label("Name") ?>

    <?= $form->field($model, 'ativo')->checkbox([
        'label' => 'Active', // Texto ao lado da checkbox
        'checked' => $model->ativo ? true : false, // Define se a checkbox estará marcada ou não
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
