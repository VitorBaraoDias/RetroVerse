<?php

/** @var yii\web\View $this */
/** @var \common\models\Artigo $model */

$this->title = 'Update Item: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="artigo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
