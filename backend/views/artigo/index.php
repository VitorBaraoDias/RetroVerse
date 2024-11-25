<?php

use common\models\Artigo;
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

    <div class="d-flex justify-content-between align-items-center">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create Artigo', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'options' => ['class' => 'mb-4'],
    ]); ?>
    <div class="input-group" style="gap:30px;">
        <?= Html::textInput('nome', $searchQuery, [
            'class' => 'form-control',
            'placeholder' => 'Search by name...',
        ]) ?>
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
    <?php ActiveForm::end(); ?>
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
