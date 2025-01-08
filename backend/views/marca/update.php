<?php

use yii\helpers\Html;

$this->title = 'Update Brand: ' . $model->nome;

?>
<div class="marca-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
