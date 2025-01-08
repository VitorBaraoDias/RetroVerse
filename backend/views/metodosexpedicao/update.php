<?php

use yii\helpers\Html;


$this->title = 'Update Shipping Method: ' . $model->nome;

?>
<div class="metodosexpedicao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
