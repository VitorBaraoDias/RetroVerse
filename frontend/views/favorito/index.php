<?php


use yii\widgets\ListView;
use common\models\Perfil;



$userId = Yii::$app->user->id;
$perfil = Perfil::findOne(['id' => $userId]);

//verificar se ele tem premium
$isPremium = $perfil ? $perfil->hasActivePremiumPlano() : false;


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
            'viewParams' => [
                'favoritos' => $favoritos, // Passa a variável 'favoritos' para a view parcial
                'isPremium' => $isPremium,
            ],
        ]) ?>

    </article>

</div>



