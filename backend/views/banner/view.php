<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Banner $model */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="banner-view">
    <!-- Exibir a imagem do banner, se existir -->
    <?php if ($model->caminhoimagem && file_exists('../../common/uploads/img-banners/' . $model->caminhoimagem)): ?>
        <div class="text-center mb-4">
            <?= Html::img('../../../common/uploads/img-banners/' . $model->caminhoimagem, [
                'alt' => 'Banner Image',
                'class' => 'img-fluid',
                'style' => 'max-width: 100%; height: auto;',
            ]) ?>
        </div>
    <?php else: ?>
        <!-- Se não houver imagem, exibir uma mensagem -->
        <div class="text-center mb-4">
            <p>No banner image available</p>
        </div>
    <?php endif; ?>

    <!-- Detalhes do banner -->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Title',
                'value' => $model->titulo ?? 'N/A',
            ],
            [
                'label' => 'Description',
                'value' => $model->descricao ?? 'N/A',
            ],
            [
                'label' => 'Button Link',
                'value' => $model->link ?? 'N/A',
            ],
            [
                'label' => 'Button Text',
                'value' => $model->textobotao ?? 'N/A',
            ],
            [
                'label' => 'Active Status',
                'value' => $model->ativo ? 'Active' : 'Inactive', // Mostra "Active" ou "Inactive"
            ],
        ],
    ]) ?>

    <div class="mt-4">
        <!-- Botões de ação -->
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data-confirm' => 'Are you sure you want to delete this banner?',
            'data-method' => 'post',
        ]) ?>
    </div>
</div>
