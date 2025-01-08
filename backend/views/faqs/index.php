<?php

use common\models\Faqs;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'FAQs';

?>
<div class="faqs-index">

    <p>
        <?= Html::a('Create Faqs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                    'attribute' => 'questao',
                    'label' => 'Question'
            ],
            [
                'attribute' => 'resposta',
                'label' => 'Answer'
            ],
            [
                'attribute' => 'categoria',
                'label' => 'Category'
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Faqs $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>
