<?php

use yii\helpers\Html;


$this->title = 'Update Estadoencomenda: ' . $model->id;

?>
<div class="estadoencomenda-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
