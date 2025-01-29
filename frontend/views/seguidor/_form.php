<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Seguidor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="seguidor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idperfil')->textInput() ?>

    <?= $form->field($model, 'idseguidor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
