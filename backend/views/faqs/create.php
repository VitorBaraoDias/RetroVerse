<?php


use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Faqs $model */

$this->title = 'Create Faqs';
$this->params['breadcrumbs'][] = ['label' => 'Faqs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faqs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
