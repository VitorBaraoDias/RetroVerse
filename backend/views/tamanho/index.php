<?php

use common\models\Tamanho;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \common\models\SearchTamanho $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tamanhos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tamanho-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tamanho', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'tamanho',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tamanho $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
