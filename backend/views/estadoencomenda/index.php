<?php

use common\models\Estadoencomenda;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\SearchEstadoencomenda $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estadoencomendas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadoencomenda-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Estadoencomenda', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descricao',
            'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Estadoencomenda $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
