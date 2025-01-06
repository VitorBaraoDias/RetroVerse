<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Metodosexpedicao $model */

$this->title = 'Create Shipping Method';

?>
<div class="metodosexpedicao-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
