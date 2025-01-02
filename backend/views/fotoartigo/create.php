<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Fotosartigo $model */

$this->title = 'Create Fotosartigo';
$this->params['breadcrumbs'][] = ['label' => 'Fotosartigos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fotosartigo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
