<?php

use common\models\Metodosexpedicao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\SearchMetodosexpedicao $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Shipping Methods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodosexpedicao-index">
    <p>
        <?= Html::a('Create New Shipping Method', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'nome',
            'label' => 'Name',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Metodosexpedicao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
