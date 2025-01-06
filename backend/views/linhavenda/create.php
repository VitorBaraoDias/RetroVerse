<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Linhavenda $model */

$this->title = 'Create Linhavenda';

?>
<div class="linhavenda-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
