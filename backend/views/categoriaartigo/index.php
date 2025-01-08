<?php

use common\models\Categoriaartigo;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Categories';
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
                'format' => 'raw',
                'value' => function($model) {
                    return $model->ativo
                        ? Html::tag('span', 'Active', ['class' => 'badge bg-success'])
                        : Html::tag('span', 'Inactive', ['class' => 'badge bg-danger']);
                },
                'filter' => [
                    1 => 'Active',
                    0 => 'Inactive',
                ],
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'prompt' => 'Select Status'
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
