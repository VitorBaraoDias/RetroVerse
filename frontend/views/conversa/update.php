<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Conversa $model */

$this->title = 'Update Conversa: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Conversas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="conversa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
