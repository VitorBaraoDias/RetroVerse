<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Metodosexpedicao $model */

$this->title = 'Update Metodosexpedicao: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Metodosexpedicaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metodosexpedicao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
