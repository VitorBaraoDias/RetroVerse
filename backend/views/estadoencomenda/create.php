<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Estadoencomenda $model */

$this->title = 'Create Estadoencomenda';
$this->params['breadcrumbs'][] = ['label' => 'Estadoencomendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadoencomenda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
