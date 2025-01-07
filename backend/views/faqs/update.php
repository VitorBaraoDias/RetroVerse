<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Faqs $model */

$this->title = 'Update FAQ: ' . $model->questao;

?>
<div class="faqs-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
