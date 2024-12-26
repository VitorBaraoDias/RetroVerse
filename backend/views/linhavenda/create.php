<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Linhavenda $model */

$this->title = 'Create Linhavenda';
$this->params['breadcrumbs'][] = ['label' => 'Linhavendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linhavenda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
