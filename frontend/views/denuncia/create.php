<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Denuncia $model */

?>
<div class="denuncia-create container d-flex justify-content-center">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'artigo' => $artigo,
    ]) ?>

</div>
