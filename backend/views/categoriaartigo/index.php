<?php

use common\models\Categoriaartigo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\SearchCategoriaartigo $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoriaartigo-index">

    <p>
        <?= Html::a('Create New Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'nome',
                'label' => 'Name',
            ],
            [
                'attribute' => 'ativo',
                'label' => 'Active Status',
                'format' => 'raw', // Exibir HTML se necessário
                'value' => function($model) {
                    return $model->ativo
                        ? Html::tag('span', 'Active', ['class' => 'badge bg-success'])
                        : Html::tag('span', 'Inactive', ['class' => 'badge bg-danger']);
                },
                'filter' => [
                    1 => 'Active',         // Opção para Ativo
                    0 => 'Inactive',       // Opção para Inativo
                ],
                'filterInputOptions' => [
                    'class' => 'form-control', // Estilo do dropdown
                    'prompt' => 'Select Status' // Texto do prompt no dropdown
                ]
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Categoriaartigo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
