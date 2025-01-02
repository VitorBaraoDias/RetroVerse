<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Plano $model */

$this->title = 'Create Plan';
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plano-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
