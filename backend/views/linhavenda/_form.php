<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Linhavenda $model */
/** @var yii\widgets\ActiveForm $form */
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
