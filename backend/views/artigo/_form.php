<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Artigo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="artigo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput() ?>

    <?= $form->field($model, 'precoanuncio')->textInput() ?>

    <?= $form->field($model, 'idcomissao')->textInput() ?>

    <?= $form->field($model, 'idestado')->textInput() ?>

    <?= $form->field($model, 'idmarca')->textInput() ?>

    <?= $form->field($model, 'idcategoria')->textInput() ?>

    <?= $form->field($model, 'idtamanho')->textInput() ?>

    <?= $form->field($model, 'idperfil')->textInput() ?>

    <?= $form->field($model, 'tipoartigo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ativo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
