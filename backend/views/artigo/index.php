<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

$this->title = 'Items';
?>
<div class="artigo-index">


    <div class="search-form mb-4">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['index'],
            'options' => ['class' => 'w-100'],
        ]); ?>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <?= $form->field($searchModel, 'nome')->textInput([
                    'placeholder' => 'Search by name',
                    'class' => 'form-control w-100',
                ])->label('Search by Name') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($searchModel, 'idmarca')->dropDownList(
                    ArrayHelper::map(\common\models\Marca::find()->all(), 'id', 'nome'),
                    ['prompt' => 'Select the brand']
                )->label('Filter by Brand') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($searchModel, 'tipoartigo')->dropDownList(
                    ['marketplace' => 'Marketplace', 'loja' => 'Loja'],
                    [
                        'prompt' => 'Select the section',
                    ]
                )->label('Filter by Section') ?>
            </div>

        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <?= $form->field($searchModel, 'tipo')->dropDownList(
                    ['premium' => 'Artigo Premium', 'normal' => 'Artigo Normal'],
                    [
                        'prompt' => 'Select the type',
                    ]
                )->label('Filter by type') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'idcategoria')->dropDownList(
                    ArrayHelper::map(\common\models\Categoriaartigo::find()->all(), 'id', 'nome'),
                    ['prompt' => 'Select the category']
                )->label('Filter by category') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'idtamanho')->dropDownList(
                    ArrayHelper::map(\common\models\Tamanho::find()->all(), 'id', 'tamanho'),
                    ['prompt' => 'Select the size']
                )->label('Filter by Size') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'ativo')->dropDownList(
                    [1 => 'Active', 0 => 'Inactive'],
                    [
                        'prompt' => 'Select Status',
                        'options' => [1 => ['Selected' => true]],
                    ]
                )->label('Status') ?>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-3">
                <?= Html::submitButton('Search', [
                    'class' => 'btn btn-primary w-100',
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= Html::a('Clear', ['index'], [
                    'class' => 'btn btn-outline-secondary w-100',
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= Html::a('Create New Item', ['create'], [
                    'class' => 'btn btn-success w-100',
                ]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_artigo',
        'layout' => '<div class="row">{items}</div>{pager}',
        'options' => ['class' => 'list-view'],
        'itemOptions' => ['class' => 'col-md-4 mb-4'],
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'options' => ['class' => 'pagination justify-content-center'],
        ],
    ]) ?>


</div>
