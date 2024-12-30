<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Estado $model */

$this->title = 'Update Condition: ' . $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'Conditions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descricao, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estado-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
