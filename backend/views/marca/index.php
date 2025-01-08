<?php

use common\models\Marca;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Brands';
?>
<div class="marca-index">

    <p>
        <?= Html::a('Add Brand', ['create'], ['class' => 'btn btn-success']) ?>
    </p>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' =>  'nome',
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
                    'class' => 'form-control', // Estilo do dropdown
                    'prompt' => 'Select Status' // Texto do prompt no dropdown
                ]
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Marca $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>



</div>
