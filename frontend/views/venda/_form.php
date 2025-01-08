<?php

use common\models\LocationHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\Venda $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="col-md-12 px-4">

    <?php $form = ActiveForm::begin(['class' => 'col-md-12']); ?>
    <h2><strong> 1. SHIPPING DETAILS </strong></h2>
    <div class="row mt-4 d-flex gap-2">
        <div class="col-md-12">
            <div class="input-details">
                <?= $form->field($model, 'nome')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Enter your name',
                    'id' => 'checkout-name'
                ])->label('Name'); ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="input-details">
                <?= $form->field($model, 'morada')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Enter your address line',
                    'id' => 'checkout-address'
                ])->label('Address Line 1'); ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="input-details">
                <?= $form->field($model, 'codigopostal')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Enter your Postal Code',
                    'id' => 'checkout-postal-code'
                ])->label('Postal Code'); ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <?= $form->field($model, 'pais')->textInput([
                    'list' => 'country-list',
                    'id' => 'checkout-country',
                    'placeholder' => 'Enter your country',
                ]) ?>
                <datalist id="country-list">
                    <?php foreach (LocationHelper::getCountries() as $code => $country): ?>
                        <option value="<?= $country ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
        </div>
        <div class="col-md-12">
            <div class="">
                <?= $form->field($model, 'cidade')->textInput([
                    'id' => 'checkout-city',
                    'placeholder' => 'Enter your city',
                ]) ?>
            </div>
        </div>
        <div class="col-12">
            <?= $form->field($model, 'idmetodoexpedicao')->dropDownList(
                ArrayHelper::map(\common\models\Metodosexpedicao::find()->all(), 'id', 'nome'),
                [
                    'prompt' => 'Select shipping method',
                    'value' => $model->idmetodoexpedicao ?? 1,
                    'class' => 'form-control w-100',
                    'id' => 'checkout-shipping-method'
                ]
            )->label('Select a carrier', ['class' => 'custom-label-class']) ?>
        </div>
        <div class="col-12 mt-2">
            <?= $form->field($model, 'idtipopagamento')->dropDownList(
                ArrayHelper::map(\common\models\Tipopagamento::find()->all(), 'id', 'descricao'),
                [
                    'prompt' => 'Select payment method',
                    'value' => $model->idtipopagamento ?? 1,
                    'class' => 'form-control w-100',
                    'id' => 'checkout-payment-method'
                ]
            )->label('Select the payment method:', ['class' => 'custom-label-class']) ?>
        </div>
        <div class="col-md-12 card outline mt-4 px-4 py-2">
            <h2><strong>COUPON CODE</strong></h2>
            <div class="input-details col-12 mb-2">
                <label class="form-label" for="login-username"></label>
                <input type="text" id="checkout-coupon-code" class="form-control" name="LoginForm[username]" autofocus="" placeholder="Add a coupon code here" aria-required="true">  <!-- Adiciona um ID para facilitar o teste -->
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('FINISH ORDER', [
                'class' => 'checkout-finish-order btn retroverse-btn active mt-4',
                'id' => 'retroverse-btn-active',
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
