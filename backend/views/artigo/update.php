<?php

/** @var yii\web\View $this */
/** @var \common\models\Artigo $model */

$this->title = 'Update Item: ' . $model->nome;
?>
<div class="artigo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
