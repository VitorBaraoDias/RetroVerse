<?php

use common\models\Plano;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $pageName */
/** @var common\models\Plano $plano */
/** @var common\models\SearchArtigo $searchModel */

?>
<div class="plano-index">
    <?= $this->render($pageName, [
        'plano' => $plano,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]); ?>
</div>