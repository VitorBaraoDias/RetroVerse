<?php


use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Faqs $model */

$this->title = 'Create FAQ';

?>
<div class="faqs-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
