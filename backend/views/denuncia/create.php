<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Denuncia $model */

$this->title = 'Create Denuncia';
$this->params['breadcrumbs'][] = ['label' => 'Denuncias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="denuncia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
