<?php


use yii\helpers\Html;


$this->title = 'Create FAQ';

?>
<div class="faqs-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
