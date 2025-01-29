<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Seguidor $model */

$this->title = 'Create Seguidor';
$this->params['breadcrumbs'][] = ['label' => 'Seguidors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seguidor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
