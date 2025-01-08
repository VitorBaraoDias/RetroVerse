<?php

use kartik\file\FileInput;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\Artigo $model */
/** @var yii\widgets\ActiveForm $form */
\yii\web\YiiAsset::register($this);

?>

<div class="artigo-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'], // para permitir upload de arquivos
    ]); ?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <?= $form->field($uploadForm, 'imageFiles[]')->fileInput([
                'multiple' => true,
                'accept' => 'image/*',
                'class' => 'form-control'
            ]) ?>

        </div>
    </div>

    <?php if (!empty($model->fotosartigos)): ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                $dataProvider = new \yii\data\ArrayDataProvider([
                    'allModels' => $model->fotosartigos, // O array de fotos
                ]);
                ?>

                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'img',
                            'format' => 'html',
                            'value' => function($model) {
                                return \yii\helpers\Html::img(Yii::getAlias('@web/uploads/img-artigos/') . $model->caminhofoto, ['class' => '', 'style' => 'width: 100px; height: 100px; object-fit: cover;']);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function($url, $model, $key) {
                                    return \yii\helpers\Html::a('Delete', ['fotoartigo/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-danger btn-sm w-100 mt-2',
                                        'data-confirm' => 'Are you sure you want to delete this photo?',
                                    ]);

                                },
                            ],
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
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
                ])->label('DESCRIBE YOUR ITEM'); ?>
            </div>
            <div class="input-details">
                <?= $form->field($model, 'idcategoria')->dropDownList(
                    ArrayHelper::map(\common\models\Categoriaartigo::find()->where(['ativo' => 1])->all(), 'id', 'nome'),
                    ['prompt' => 'Select a category', 'class' => 'form-control w-100']
                )->label('CATEGORY', ['class' => 'custom-label-class']) ?>
            </div>
            <div class="input-details">
                <?= $form->field($model, 'idmarca')->dropDownList(
                    ArrayHelper::map(\common\models\Marca::find()->where(['ativo' => 1])->all(), 'id', 'nome'),
                    ['prompt' => 'Select a brand', 'class' => 'form-control input-details w-100']
                )->label('BRAND', ['class' => 'custom-label-class mt-4']) ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'idestado')->dropDownList(ArrayHelper::map(\common\models\Estado::find()->all(), 'id', 'descricao'),
                        ['prompt' => 'Select a condition', 'class' => 'form-control input-details w-100']
                    )->label('CONDITION', ['class' => 'custom-label-class mt-4']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'idtamanho')->dropDownList(ArrayHelper::map(\common\models\Tamanho::find()->all(), 'id', 'tamanho'),
                        ['prompt' => 'Select a size', 'class' => 'form-control input-details w-100']
                    )->label('SIZE', ['class' => 'custom-label-class mt-4']) ?>
                </div>
            </div>
            <div class="input-details mt-4">
                <?= $form->field($model, 'precoanuncio')->textInput([
                    'autofocus' => true,
                    'type' => 'number',
                    'placeholder' => '€ 0.00'
                ])->label('PRICE'); ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton($textContentButton, [
                    'class' => 'btn retroverse-btn active w-100 mt-3 px-5 py-2 rounded-0',
                    'id' => "retroverse-btn-active"
                ]) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


