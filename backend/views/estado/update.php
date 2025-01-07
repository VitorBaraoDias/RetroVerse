<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Estado $model */

$this->title = 'Update Condition: ' . $model->descricao;
?>
<div class="estado-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
