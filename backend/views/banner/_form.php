<?php
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?php if ($model->caminhoimagem): ?>
        <div class="form-group">
            <label>Current Banner</label><br>
            <img src="<?= \yii\helpers\Url::to('../../../common/uploads/img-banners/' . $model->caminhoimagem) ?>" alt="Current Banner Image" style="max-width: 100%; height: auto; max-height: 200px; object-fit: cover;">
            <br><br>
        </div>
    <?php endif; ?>


    <?= $form->field($uploadModel, 'imageFile')->label('Upload New Banner')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'showUpload' => false,
            'browseOnZoneClick' => true,
            'initialPreviewAsData' => true,
            'maxFileSize' => 2000,
            'previewFileType' => 'image',
        ],
    ]) ?>


    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true])->label('Title') ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6])->label('Description') ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true])->label('Button Link') ?>

    <?= $form->field($model, 'textobotao')->textInput(['maxlength' => true])->label('Button Text') ?>

    <?= $form->field($model, 'ativo')->checkbox()->label('Active') ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
