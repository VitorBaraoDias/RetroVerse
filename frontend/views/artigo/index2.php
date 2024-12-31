<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@vendor/kartik-v/yii2-widget-fileinput/css/fileinput.min.css'); // CSS
$this->registerJsFile('@vendor/kartik-v/yii2-widget-fileinput/js/fileinput.min.js', ['position' => \yii\web\View::POS_END]); // JS

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]);

echo $form->field($model, 'descricao')->widget(FileInput::classname(), [
    'options' => ['multiple' => true],
    'pluginOptions' => [
        'showUpload' => true,
        'browseOnZoneClick' => true,
        'initialPreviewAsData' => true,
        'maxFileSize' => 2000,
        'previewFileType' => 'image',
    ],
]);

ActiveForm::end();
?>
<?php
