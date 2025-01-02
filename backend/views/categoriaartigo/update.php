<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Categoriaartigo $model */

$this->title = 'Update Categoriaartigo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Categoriaartigos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categoriaartigo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
