<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Categoriaartigo $model */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoriaartigo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
