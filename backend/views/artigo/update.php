<?php

/** @var yii\web\View $this */
/** @var \common\models\Artigo $model */

$this->title = 'Update Artigo: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Artigos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="artigo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
