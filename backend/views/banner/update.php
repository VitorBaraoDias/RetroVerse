<?php

use yii\helpers\Html;


$this->title = 'Update Banner: ' . $model->titulo;
?>
<div class="banner-update">

    <?= $this->render('_form', [
        'model' => $model,
        'uploadModel' => $uploadModel,
    ]) ?>

</div>
