<?php

use common\models\Tamanho;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \common\models\SearchTamanho $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sizes';

?>
<div class="tamanho-index">

    <p>
        <?= Html::a('Create New Size', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'label' => "Size",
              'attribute' =>    'tamanho',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tamanho $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
