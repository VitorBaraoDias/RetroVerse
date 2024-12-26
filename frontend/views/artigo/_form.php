<?php

use kartik\file\FileInput;
use kartik\file\FileInputAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Artigo $model */
/** @var yii\widgets\ActiveForm $form */
\yii\web\YiiAsset::register($this);
?>

<div class="artigo-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'], // para permitir upload de arquivos

    ]); ?>
    <?= $form->field($uploadForm, 'imageFiles[]')->widget(FileInput::classname(), [
        'options' => [
            'multiple' => true, // Permitir múltiplos uploads
            'accept' => 'image/*', // Restringir para arquivos de imagem
        ],
        'pluginOptions' => [
            'showUpload' => false, // Desativar upload automático do plugin
            'browseOnZoneClick' => true, // Abrir seletor ao clicar na área
            'initialPreviewAsData' => true, // Mostrar pré-visualização das imagens
            'maxFileSize' => 2000, // Tamanho máximo por arquivo em KB
            'previewFileType' => 'image', // Mostrar pré-visualização apenas para imagens
            'overwriteInitial' => false, // Não sobrescrever pré-visualizações iniciais
            'maxFileCount' => 4, // Limitar o número de arquivos
        ],
    ]); ?>
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-6">
            <div class="input-details">
                <?= $form->field($model, 'nome')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'White sweater by Nike'
                ])->label('TITLE'); ?>
            </div>
            <div class="input-details">
                <?= $form->field($model, 'descricao')->textarea([
                    'autofocus' => true,
                    'placeholder' => 'White sweater by Nike'
                ])->label('DESCRIBE YOUR ARTICLE'); ?>
            </div>
            <div class="input-details">
                    <?= $form->field($model, 'idcategoria')->dropDownList(
                        ArrayHelper::map(\common\models\Categoriaartigo::find()->all(), 'id', 'nome'),
                        ['prompt' => 'Select a category', 'class' => 'form-control w-100']
                    )->label('CATEGORY', ['class' => 'custom-label-class']) ?>
            </div>
            <div class="input-details">
                <?= $form->field($model, 'idmarca')->dropDownList(ArrayHelper::map(\common\models\Marca::find()->all(), 'id', 'nome'),
                    ['prompt' => 'Select a brand', 'class' => 'form-control input-details w-100']
                )->label('BRAND', ['class' => 'custom-label-class mt-4']) ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'idestado')->dropDownList(ArrayHelper::map(\common\models\Estado::find()->all(), 'id', 'descricao'),
                        ['prompt' => 'Select a condition', 'class' => 'form-control input-details w-100']
                    )->label('BRAND', ['class' => 'custom-label-class mt-4']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'idtamanho')->dropDownList(ArrayHelper::map(\common\models\Tamanho::find()->all(), 'id', 'tamanho'),
                        ['prompt' => 'Select a size', 'class' => 'form-control input-details w-100']
                    )->label('BRAND', ['class' => 'custom-label-class mt-4']) ?>
                </div>
            </div>
            <div class="input-details mt-4">
                <?= $form->field($model, 'precoanuncio')->textInput([
                    'autofocus' => true,
                    'placeholder' => '€ 0.00'
                ])->label('PRICE'); ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton($textContentButton, ['class' => 'btn retroverse-btn active w-100 mt-3 px-5 py-2 rounded-0', 'id' => "retroverse-btn-active"]) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
