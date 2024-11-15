<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Categoriaartigo $model */

$this->title = 'Create Categoriaartigo';
$this->params['breadcrumbs'][] = ['label' => 'Categoriaartigos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoriaartigo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
