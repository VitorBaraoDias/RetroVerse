<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Banner $model */

$this->title = 'Update Banner: ' . $model->titulo;
?>
<div class="banner-update">

    <?= $this->render('_form', [
        'model' => $model,
        'uploadModel' => $uploadModel,
    ]) ?>

</div>
