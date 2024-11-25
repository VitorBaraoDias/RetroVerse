<?php

use yii\bootstrap5\Carousel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\Artigo $model */

$this->title = "Article:".$model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Artigos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="artigo-view">

    <?php if ($model->fotosartigos): ?>
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            This article has photos.
            <?= Html::a('Add', ['fotoartigo/create', 'id' => $model->id], [
                'class' => 'btn btn-primary float-right',
                'data' => [
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning d-flex justify-content-between align-items-center">
            <div>
                <strong>Attention:</strong> This article has no photos!
            </div>
            <?= Html::a('Add', ['fotoartigo/create', 'id' => $model->id], [
                'class' => 'btn btn-primary float-right',
                'data' => [
                    'confirm' => 'This article has no photos!',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($model->fotosartigos)): ?>
        <div class="mt-4">
            <?php
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $model->fotosartigos, // O array de fotos
            ]);
            ?>

            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'img',
                        'format' => 'html',
                        'value' => function($model) {
                            return \yii\helpers\Html::img('../../../common/uploads/img-artigos/' . $model->caminhofoto, ['class' => '', 'style' => 'width: 100px; height: 100px; object-fit: cover;']);
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function($url, $model, $key) {
                                // Formulário para exclusão
                                return \yii\helpers\Html::a('Excluir', ['fotoartigo/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger btn-sm w-100 mt-2',
                                    'data-confirm' => 'Tem certeza de que deseja excluir este artigo?',
                                    'data-method' => 'post',
                                ]);
                            },
                        ],
                    ],
                ],
            ]) ?>

        </div>
    <?php endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nome',
            'descricao',
            'precoanuncio',
            [
                'label' => 'Comissão',
                'value' => $model->idcomissao0->comissao ?? 'N/A',
            ],
            [
                'label' => 'Estado',
                'value' => $model->idestado0->descricao ?? 'N/A', // Exibe o nome do estado
            ],
            [
                'label' => 'Marca',
                'value' => $model->idmarca0->nome ?? 'N/A', // Exibe o nome da marca
            ],
            [
                'label' => 'Categoria',
                'value' => $model->idcategoria0->nome ?? 'N/A', // Exibe o nome da categoria
            ],
            [
                'label' => 'Tamanho',
                'value' => $model->idtamanho0->tamanho ?? 'N/A', // Exibe a descrição do tamanho
            ],
            [
                'label' => 'Perfil',
                'value' => $model->idperfil0->nome ?? 'N/A', // Exibe o nome do perfil
            ],
            'tipoartigo',
            [
                'label' => 'Ativo',
                'value' => $model->ativo ? 'Sim' : 'Não', // Mostra "Sim" ou "Não" para ativo
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


</div>
