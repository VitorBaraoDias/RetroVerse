<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Metodosexpedicao $model */

$this->title = 'Create Metodosexpedicao';
$this->params['breadcrumbs'][] = ['label' => 'Metodosexpedicaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodosexpedicao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
