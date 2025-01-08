<?php

use common\models\Iva;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="plano-form">


    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'precomensal')->textInput(['maxlength' => true])->label('Monthly Price', ['class' => 'custom-label-class']) ?>


    <?= $form->field($model, 'idiva')->dropDownList(ArrayHelper::map(Iva::find()->where(['emvigor' => 1])->all(), 'id', 'percentagem'), ['prompt' => 'Select the IVA']
    )->label('IVA (%)', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true])->label('Description', ['class' => 'custom-label-class']) ?>

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
