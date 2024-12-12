<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\VendaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="venda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idcomprador') ?>

    <?= $form->field($model, 'idmetodoexpedicao') ?>

    <?= $form->field($model, 'idtipopagamento') ?>

    <?= $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'datavenda') ?>

    <?php // echo $form->field($model, 'idestadoencomenda') ?>

    <?php // echo $form->field($model, 'nome') ?>

    <?php // echo $form->field($model, 'codigopostal') ?>

    <?php // echo $form->field($model, 'morada') ?>

    <?php // echo $form->field($model, 'pais') ?>

    <?php // echo $form->field($model, 'cidade') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
