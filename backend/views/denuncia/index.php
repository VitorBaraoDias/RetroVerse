<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\DenunciaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Item Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="denuncia-index">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_denuncia_card',
        'layout' => "{items}\n{pager}",
        'options' => ['class' => 'row'],
        'itemOptions' => ['class' => 'col-md-4 mb-4'],
    ]); ?>

</div>
