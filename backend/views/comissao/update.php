<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\comissao $model */

$this->title = 'Update Comission: ' . $model->comissao;
?>
<div class="comissao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
