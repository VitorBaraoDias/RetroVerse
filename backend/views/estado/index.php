<?php

use common\models\Estado;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Conditions';
?>
<div class="estado-index">

    <p>
        <?= Html::a('Create Condition', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
               'attribute' => 'descricao',
                'label' => 'Description',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Estado $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>




</div>
