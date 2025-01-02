<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\LinhavendaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linhavenda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idvenda') ?>

    <?= $form->field($model, 'idartigo') ?>

    <?= $form->field($model, 'idvendedor') ?>

    <?= $form->field($model, 'idestadoencomenda') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
