<?php

use common\models\Artigo;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\SearchArtigo $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Artigos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artigo-index">


    <div class="search-form mb-4">
        <?php $form = ActiveForm::begin([
            'method' => 'get', // Envia os dados como GET
            'action' => ['index'], // A URL para onde os dados serão enviados
            'options' => ['class' => 'w-100'], // Garante largura total
        ]); ?>

        <!-- Inputs na parte superior -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <?= $form->field($searchModel, 'nome')->textInput([
                    'placeholder' => 'Search by title',
                    'class' => 'form-control w-100',
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($searchModel, 'idmarca')->dropDownList(
                    ArrayHelper::map(\common\models\Marca::find()->all(), 'id', 'nome'),
                    ['prompt' => 'Selecione a marca']
                )->label('Selecione a marca') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'idcategoria')->dropDownList(
                    ArrayHelper::map(\common\models\Categoriaartigo::find()->all(), 'id', 'nome'),
                    ['prompt' => 'Selecione a categoria']
                )->label('Selecione a categoria') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'idtamanho')->dropDownList(
                    ArrayHelper::map(\common\models\Tamanho::find()->all(), 'id', 'tamanho'),
                    ['prompt' => 'Selecione o tamanho']
                )->label('Selecione o tamanho') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'ativo')->dropDownList(
                    [1 => 'Active', 0 => 'Inactive'], // Opções do dropdown
                    [
                        'prompt' => 'Select Status',
                        'options' => [1 => ['Selected' => true]], // Define o "Active" como selecionado por padrão
                    ]
                )->label('Status') ?>
            </div>
        </div>

        <!-- Botões na parte inferior -->
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
                <?= Html::a('Create Artigo', ['create'], [
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
