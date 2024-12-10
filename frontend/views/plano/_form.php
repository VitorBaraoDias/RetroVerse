<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Plano $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="plano-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'precomensal')->textInput() ?>

    <?= $form->field($model, 'idiva')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ativo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
