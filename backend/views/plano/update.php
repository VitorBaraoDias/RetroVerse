<?php

use yii\helpers\Html;

$this->title = 'Update Plan: ' . $model->descricao;

?>
<div class="plano-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
