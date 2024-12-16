<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Perfil $model */

?>
<div class="perfil-update container-lg">

    <h1 class="p-4"><strong>EDIT PROFILE</strong></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadForm' => $uploadForm,
    ]) ?>

</div>
