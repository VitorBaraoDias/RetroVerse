<?php

use kartik\file\FileInput;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
/** @var yii\web\View $this */
/** @var common\models\Artigo $model */

$this->title = "Item: ".$model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="artigo-view">



    <?php $form = ActiveForm::begin([
        'action' => ['fotoartigo/create', 'id' => $model->id],
        'options' => ['enctype' => 'multipart/form-data'], // para permitir upload de arquivos
    ]); ?>
    <!-- Campo de upload usando FileInput -->
    <?= $form->field($uploadForm, 'imageFiles[]')->widget(FileInput::classname(), [
        'options' => [
            'multiple' => true, // Permitir múltiplos uploads
            'accept' => 'image/*', // Restringir para arquivos de imagem
        ],
        'pluginOptions' => [
            'showUpload' => false, //
            'browseOnZoneClick' => true, // Permitir abrir o seletor clicando na área
            'initialPreviewAsData' => true,
            'maxFileSize' => 2000,
            'previewFileType' => 'image',
        ],
    ]); ?>

    <!-- Botão de envio -->
    <div class="form-group">
        <?= Html::submitButton('Upload Photos', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


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
                                return \yii\helpers\Html::a('Delete', ['fotoartigo/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger btn-sm w-100 mt-2',
                                    'data-confirm' => 'Are you sure you want to delete this photo?',
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
            [
                'label' => 'Name',
                'value' => $model->nome ?? 'N/A',
            ],
            [
                'label' => 'Description',
                'value' => $model->descricao ?? 'N/A',
            ],
            [
                'label' => 'Price',
                'value' => $model->precoanuncio ?? 'N/A',
            ],
            [
                'label' => 'Comission',
                'value' => $model->idcomissao0->comissao ?? 'N/A',
            ],
            [
                'label' => 'Condition',
                'value' => $model->idestado0->descricao ?? 'N/A', // Exibe o nome do estado
            ],
            [
                'label' => 'Brand',
                'value' => $model->idmarca0->nome ?? 'N/A', // Exibe o nome da marca
            ],
            [
                'label' => 'Category',
                'value' => $model->idcategoria0->nome ?? 'N/A', // Exibe o nome da categoria
            ],
            [
                'label' => 'Size',
                'value' => $model->idtamanho0->tamanho ?? 'N/A', // Exibe a descrição do tamanho
            ],
            [
                'label' => 'Profile',
                'value' => $model->idperfil0->nome ?? 'N/A', // Exibe o nome do perfil
            ],

            [
                'label' => 'Section',
                'value' => $model->tipoartigo ?? 'N/A',
            ],
            [
                'label' => 'Active Status',
                'value' => $model->ativo ? 'Active' : 'Inactive', // Mostra "Sim" ou "Não" para ativo
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
