<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Categoriaartigo $model */

$this->title = 'Create Category';

?>
<div class="categoriaartigo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
