<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Tamanho $model */

$this->title = 'Update Size: ' . $model->tamanho;
$this->params['breadcrumbs'][] = ['label' => 'Sizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tamanho-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
