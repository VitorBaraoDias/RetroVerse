<?php

use common\models\Iva;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\Plano $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="plano-form">


    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'precomensal')->textInput(['maxlength' => true])->label('Preço Mensal', ['class' => 'custom-label-class']) ?>


    <?= $form->field($model, 'idiva')->dropDownList(ArrayHelper::map(Iva::find()->where(['emvigor' => 1])->all(), 'id', 'percentagem'), ['prompt' => 'Selecione o IVA']
    )->label('Selecione o IVA (%)', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true])->label('Descrição do Plano', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'ativo')->checkbox([
        'label' => 'Active',
        'uncheck' => 0,
        'checked' => 1,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
