<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;

YiiAsset::register($this);


/** @var yii\web\View $this */
/** @var common\models\Clientesplano $model */

$this->title = $model->id;
\yii\web\YiiAsset::register($this);

$form = ActiveForm::begin([
    'action' => ['delete', 'id' => $model->id],
    'method' => 'post',
]);
?>
<div class="clientesplano-view">

    <h1 class="text-center"><strong>MY PREMIUM PLAN</strong></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'expira',
        ],
    ]) ?>

    <div class="form-group">
        <?= yii\helpers\Html::submitButton('CANCEL MY PLAN', ['class' => 'btn btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>



</div>
