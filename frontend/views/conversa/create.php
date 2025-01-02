<?php

/** @var yii\web\View $this */
/** @var \common\models\Listachats $model */

?>
<div class="conversa-create">

    <?= $this->render('_form', [
        'model' => $model,
        'idchat' => $idchat, // Passa o id do chat atual
        'modelTexto' => $modelTexto,

    ]) ?>

</div>
