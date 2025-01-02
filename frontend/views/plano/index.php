<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $pageName */
/** @var \common\models\Plano $plano */
/** @var common\models\SearchArtigo $searchModel */

$this->title = 'Planos';
?>

<div class="plano-index">
    <?= $this->render($pageName, [
        'plano' => $plano,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]); ?>
</div>