<?php

use common\models\Plano;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\SearchPlano $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Plans';
$this->params['breadcrumbs'][] = $this->title;
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
                'label' => 'IVA (%)', // Rótulo personalizado para a coluna
            ],
            [
                    'attribute' => 'descricao',
                    'label' => 'Description',
                ],
            [
                'attribute' => 'ativo',
                'format' => 'raw', // Exibir HTML se necessário
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
