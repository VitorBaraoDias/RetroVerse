<?php

use yii\helpers\Html;


$this->title = 'Update Iva: ' . $model->id;

?>
<div class="iva-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
