<?php

use yii\helpers\Html;


$this->title = 'Update Size: ' . $model->tamanho;

?>
<div class="tamanho-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
