<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Plano $model */

$this->title = 'Update Plan: ' . $model->descricao;

?>
<div class="plano-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
