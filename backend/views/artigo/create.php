<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Artigo $model */

$this->title = 'Create Item';
?>
<div class="artigo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
