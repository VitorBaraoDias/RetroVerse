<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Banner $model */

$this->title = 'Create Banner';

?>
<div class="banner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadModel' => $uploadModel,
    ]) ?>

</div>
