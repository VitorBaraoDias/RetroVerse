<?php


use common\models\Favorito;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;


/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Favourites';
?>
<div class="favorito-index">




    <article class="container" style="margin-top: 45px;">
        <h2 class="text-center fw-bolder mb-4 " style="font-weight: bold;">FAVOURITES</h2>
        <!-- Card 1 -->
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_artigo_card',  // Especifica o arquivo de item que criamos
            'layout' => '<div class="row">{items}</div>{pager}',  // Layout com items e paginação
            'options' => ['class' => 'list-view'],  // Classe opcional para estilização adicional
            'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 card-product'],  // Estilo para cada item
            'pager' => [
                'class' => \yii\bootstrap5\LinkPager::class,
                'options' => ['class' => 'pagination justify-content-center'],
            ],
        ]) ?>

    </article>

</div>



