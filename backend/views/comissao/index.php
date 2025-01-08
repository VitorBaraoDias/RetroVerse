<?php

use common\models\comissao;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Comissions';
?>
<div class="comissao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comission', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'comissao',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, comissao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
            [
                'attribute' => 'ativo',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->ativo
                        ? Html::tag('span', 'Ativo', ['class' => 'badge bg-success'])
                        : Html::tag('span', 'Inativo', ['class' => 'badge bg-danger']);
                },
            ],
        ],
    ]); ?>


</div>
