<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\FaqsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="faqs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'questao')->label("Question") ?>

    <?= $form->field($model, 'resposta')->label("Answer") ?>

    <?= $form->field($model, 'categoria')->label("Category") ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
