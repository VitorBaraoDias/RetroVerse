<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\LocationHelper;

/** @var yii\web\View $this */
/** @var \common\models\Perfil $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container d-flex justify-content-center align-items-center">
    <div class="col-md-6">
        <div class="edit-shipping-form">
            <h2 class="mb-4"><strong>MY SHIPPING DETAILS </strong></h2>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="input-details">
                <?= $form->field($model, 'nome')->textInput(['autofocus' => true, 'placeholder' => 'Enter your name'])->label('Name'); ?>
            </div>
            <div class="input-details">
                <?= $form->field($model, 'codigopostal')->textInput(['placeholder' => 'Enter your postal code'])->label('Postal Code'); ?>
            </div>
            <div class="input-details">
                <?= $form->field($model, 'morada')->textInput(['placeholder' => 'Enter your address'])->label('Address Line 1'); ?>
            </div>
            <div class="input-details">
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
            <div class="input-details">
                <?= $form->field($model, 'cidade')->textInput(['placeholder' => 'Enter your city'])->label('City'); ?>
            </div>
            <div class="form-group d-flex justify-content-end mt-4">
                <?= Html::submitButton('CONFIRM', ['class' => 'btn retroverse-btn active w-auto px-5 py-2', 'id' => "retroverse-btn-active"]) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

