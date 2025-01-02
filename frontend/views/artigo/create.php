<?php

/** @var yii\web\View $this */
/** @var \common\models\Artigo $model */

?>
<div class="artigo-create mx-5">

    <h1><strong>PUBLISH AN ITEM</strong> </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadForm' => $uploadForm,
        'textContentButton' => 'PUBLISH ITEM',
        'disable' => false,
    ]) ?>

</div>
