<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Tamanho $model */

$this->title = 'Create Size';

?>
<div class="tamanho-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
