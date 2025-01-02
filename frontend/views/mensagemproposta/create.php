<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Mensagemproposta $model */

?>
<div class="mensagemproposta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'idchat' => $idchat,
    ]) ?>

</div>
