<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Artigospremium $model */

$this->title = 'Update Artigospremium: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Artigospremia', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="artigospremium-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
