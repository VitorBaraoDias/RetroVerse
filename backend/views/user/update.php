<?php

use yii\helpers\Html;


$this->title = 'Update User: ' . $model->id;

?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
