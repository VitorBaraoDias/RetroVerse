<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Artigospremium $model */

$this->title = 'Atrbuir como artigo premium';
//$this->params['breadcrumbs'][] = ['label' => 'Artigospremium', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artigospremium-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
