<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tamanho $model */

$this->title = 'Create Size';
$this->params['breadcrumbs'][] = ['label' => 'Sizes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tamanho-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
