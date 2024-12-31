<?php

use kartik\file\FileInput;
use yii\bootstrap5\BootstrapAsset;
use yii\web\AssetBundle;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Artigo $model */

$this->title = 'Update Artigo: ' . $model->id;
?>
<div class="artigo-update mx-5">

    <h1> <strong>EDIT ITEM</strong></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadForm' => $uploadForm, // Envie a variável para a view
        'textContentButton' => 'EDIT ITEM',
        'disable' => true,
    ]) ?>

</div>
