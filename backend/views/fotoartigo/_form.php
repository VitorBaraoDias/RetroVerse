<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Fotosartigo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fotosartigo-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'] //
    ]) ; ?>


    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end() ?>

</div>
