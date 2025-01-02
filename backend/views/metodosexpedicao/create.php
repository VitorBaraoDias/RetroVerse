<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Metodosexpedicao $model */

$this->title = 'Create Shipping Method';
$this->params['breadcrumbs'][] = ['label' => 'Shipping Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodosexpedicao-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
