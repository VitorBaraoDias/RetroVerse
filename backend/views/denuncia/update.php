<?php

use yii\helpers\Html;



$this->title = 'Update Denuncia: ' . $model->id;
?>
<div class="denuncia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
