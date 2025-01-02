<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Faqs $model */

$this->title = 'Update FAQ: ' . $model->questao;
$this->params['breadcrumbs'][] = ['label' => 'FAQS', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faqs-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
