<?php

use common\models\Banner;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\BannerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Banners';

?>
<div class="banner-index">

    <p>
        <?= Html::a('Create Banner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,  // O DataProvider que irá fornecer os dados dos banners
        'itemView' => '_banner',           // A parcial que será usada para exibir cada banner
        'layout' => '<div class="row">{items}</div>{pager}',  // Layout da listagem
        'options' => ['class' => 'list-view'],  // Classe do contêiner da ListView
        'itemOptions' => ['class' => 'col-md-4 mb-4'],  // Cada item será exibido em uma coluna de 4
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'options' => ['class' => 'pagination justify-content-center'],  // Classe para o pager
        ],
    ]) ?>


</div>
