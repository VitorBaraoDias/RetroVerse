<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Estado $model */

$this->title = 'Create Condition';
$this->params['breadcrumbs'][] = ['label' => 'Conditions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estado-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
