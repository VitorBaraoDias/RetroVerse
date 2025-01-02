<?php


use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Artigo $model */

$this->title = 'Atribuir como Artigo Premium: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Artigos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Premium';
?>
<div class="artigo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_premium_form', [
        'model' => $model,
    ]) ?>

</div>