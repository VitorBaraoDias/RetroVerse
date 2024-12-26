<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ClientesPlano $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="clientesplano-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Campos ocultos para idperfil e idplano -->
    <?= $form->field($model, 'idperfil')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'idplano')->hiddenInput()->label(false) ?>

    <!-- Contêiner Centralizado -->
    <div class="d-flex flex-column align-items-center mt-4">

        <!-- Dropdown de Método de Pagamento -->
        <div class="col-12 col-md-4 mb-3">
            <label class="custom-label-class">Selecione o método de pagamento</label>
            <?= Html::dropDownList(
                'idtipopagamento',
                1,
                ArrayHelper::map(\common\models\Tipopagamento::find()->all(), 'id', 'descricao'),
                [
                    'prompt' => 'Select pay method',
                    'class' => 'form-control w-100',
                ]
            ) ?>
        </div>

        <div class="col-12 col-md-4">
            <?= Html::submitButton('FINISH', ['class' => 'premium-btn w-100 ']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>


