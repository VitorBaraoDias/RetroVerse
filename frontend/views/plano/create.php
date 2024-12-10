<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Plano $model */

$this->title = 'Create Plano';
$this->params['breadcrumbs'][] = ['label' => 'Planos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plano-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
