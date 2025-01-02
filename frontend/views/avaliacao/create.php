<?php

/** @var yii\web\View $this */
/** @var \common\models\Avaliacao $model */
?>
<div class="avaliacao-create container">

    <?= $this->render('_form', [
        'model' => $model,
        'linhaVenda' => $linhaVenda,
    ]) ?>

</div>
