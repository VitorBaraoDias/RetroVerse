<?php

use yii\helpers\Html;


$this->title = 'Update Condition: ' . $model->descricao;
?>
<div class="estado-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
