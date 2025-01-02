<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\comissao $model */

$this->title = 'Create Comission';
$this->params['breadcrumbs'][] = ['label' => 'Comission', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comissao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
