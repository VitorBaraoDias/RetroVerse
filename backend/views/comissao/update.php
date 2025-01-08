<?php

use yii\helpers\Html;


$this->title = 'Update Comission: ' . $model->comissao;
?>
<div class="comissao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
