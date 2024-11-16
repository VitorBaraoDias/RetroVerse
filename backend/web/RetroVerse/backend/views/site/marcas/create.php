<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Marcas $model */

$this->title = 'Create Marcas';
$this->params['breadcrumbs'][] = ['label' => 'Marcas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marcas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
