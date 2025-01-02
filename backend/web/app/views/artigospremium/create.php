<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Artigospremium $model */

$this->title = 'Create Artigospremium';
$this->params['breadcrumbs'][] = ['label' => 'Artigospremia', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artigospremium-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
