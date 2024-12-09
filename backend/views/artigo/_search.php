<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SearchArtigo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="artigo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'precoanuncio') ?>

    <?= $form->field($model, 'idcomissao') ?>

    <?php // echo $form->field($model, 'idestado') ?>

    <?php // echo $form->field($model, 'idmarca') ?>

    <?php // echo $form->field($model, 'idcategoria') ?>

    <?php // echo $form->field($model, 'idtamanho') ?>

    <?php // echo $form->field($model, 'idperfil') ?>

    <?php // echo $form->field($model, 'tipoartigo') ?>

    <?php // echo $form->field($model, 'ativo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
