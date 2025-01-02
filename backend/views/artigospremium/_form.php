<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// Para mapear dados para o dropdown

/** @var yii\web\View $this */
/** @var \common\models\Artigospremium $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \common\models\Plano[] $planos */

?>

<div class="artigospremium-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campo oculto para 'idartigo' -->
    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <!-- Dropdown para 'idPlano' -->
    <?= $form->field($model, 'idPlano')->dropDownList(
        ArrayHelper::map(\common\models\Plano::find()->all(), 'id', 'descricao'), ['prompt' => 'Selecione um plano'])->label('Plano a Associar:') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


