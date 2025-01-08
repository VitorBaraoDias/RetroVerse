<?php

use common\models\Plano;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Plans';
?>
<div class="plano-index">


    <p>
        <?= Html::a('Create New Plan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'attribute' => 'precomensal',
                    'label' => 'Monthly Payment',
            ],
            [
                'attribute' => 'idiva',
                'value' => function ($model) {
                    return $model->iva ? $model->iva->percentagem . '%' : null;
                },
                'label' => 'IVA (%)',
            ],
            [
                    'attribute' => 'descricao',
                    'label' => 'Description',
                ],
            [
                'attribute' => 'ativo',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->ativo
                        ? Html::tag('span', 'Active', ['class' => 'badge bg-success'])
                        : Html::tag('span', 'Inactive', ['class' => 'badge bg-danger']);
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Plano $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],

        ],
    ]); ?>


</div>
