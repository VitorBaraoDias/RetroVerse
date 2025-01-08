<?php

use yii\helpers\Html;


$this->title = 'Update FAQ: ' . $model->questao;

?>
<div class="faqs-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
