<?php

use common\models\Artigo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>
<div class="banner-collection">
    <div class="banner-collection-text">COLLECTION</div>
</div>
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar Filters (à esquerda) -->
        <div class="col-md-3">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'],
                'options' => ['class' => ''],
            ]); ?>

            <!-- CATEGORY Filter -->
            <?= $form->field($searchModel, 'idcategoria')->dropDownList(
                ArrayHelper::map(\common\models\Categoriaartigo::find()->all(), 'id', 'nome'),
                [
                    'prompt' => 'SELECIONE A CATEGORIA',
                    'class' => 'mb-3 filter-dropdown',
                    'options' => [
                        '' => ['disabled' => true, 'selected' => true], // Garante que o prompt esteja desabilitado e selecionado por padrão
                    ],
                ]
            )->label(false) ?>

            <!-- SIZE Filter -->
            <?= $form->field($searchModel, 'idtamanho')->dropDownList(
                ArrayHelper::map(\common\models\Tamanho::find()->all(), 'id', 'tamanho'),
                [
                    'prompt' => 'SELECIONE O TAMANHO',
                    'class' => 'mb-3 filter-dropdown',
                    'options' => [
                        '' => ['disabled' => true, 'selected' => true],
                    ],
                ]
            )->label(false) ?>

            <!-- CONDITION Filter -->
            <?= $form->field($searchModel, 'idestado')->dropDownList(
                ArrayHelper::map(\common\models\Estado::find()->all(), 'id', 'descricao'),
                [
                    'prompt' => 'SELECIONE A CONDIÇÃO',
                    'class' => 'mb-3 filter-dropdown',
                    'options' => [
                        '' => ['disabled' => true, 'selected' => true],
                    ],
                ]
            )->label(false) ?>

            <!-- BRAND Filter -->
            <?= $form->field($searchModel, 'idmarca')->dropDownList(
                ArrayHelper::map(\common\models\Marca::find()->all(), 'id', 'nome'),
                [
                    'prompt' => 'SELECIONE A MARCA',
                    'class' => 'mb-3 filter-dropdown',
                    'options' => [
                        '' => ['disabled' => true, 'selected' => true],
                    ],
                ]
            )->label(false) ?>


            <div class="mb-3">
                <!-- Slider para o preço mínimo -->
                <input type="range" class="form-range" id="preco_min_range" name="SearchArtigo[preco_min]"
                       min="0" max="1000" step="10" value="<?= isset($searchModel->preco_min) ? $searchModel->preco_min : 0 ?>"
                       oninput="updateRangeValues()">

                <!-- Slider para o preço máximo -->
                <input type="range" class="form-range" id="preco_max_range" name="SearchArtigo[preco_max]"
                       min="0" max="1000" step="10" value="<?= isset($searchModel->preco_max) ? $searchModel->preco_max : 1000 ?>"
                       oninput="updateRangeValues()">

                <!-- Display the selected values -->
                <div class="d-flex justify-content-between">
                    <span id="preco_min_value"><?= isset($searchModel->preco_min) ? $searchModel->preco_min : 0 ?></span>
                    <span>até</span>
                    <span id="preco_max_value"><?= isset($searchModel->preco_max) ? $searchModel->preco_max : 1000 ?></span>
                </div>
            </div>

            <!-- Campos ocultos para os valores de preco_min e preco_max -->
            <input type="hidden" name="SearchArtigo[preco_min]" id="preco_min" value="<?= isset($searchModel->preco_min) ? $searchModel->preco_min : 0 ?>">
            <input type="hidden" name="SearchArtigo[preco_max]" id="preco_max" value="<?= isset($searchModel->preco_max) ? $searchModel->preco_max : 1000 ?>">


            <!-- Search Button -->
            <div class="mt-3">
                <button style="padding: 10px 5px; font-weight:700" type="submit" id="retroverse-btn-active" class="btn retroverse-btn active">SEARCH</button>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <!-- Products List (à direita) -->
        <div class="col-md-9">
            <!-- Card 1 -->
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_artigo_card',  // Especifica o arquivo de item que criamos
                'layout' => '<div class="row">{items}</div>{pager}',  // Layout com items e paginação
                'options' => ['class' => 'list-view'],  // Classe opcional para estilização adicional
                'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 card-product mt-4'],  // Estilo para cada item
                'pager' => [
                    'class' => \yii\bootstrap5\LinkPager::class,
                    'options' => ['class' => 'pagination justify-content-center'],
                ],
            ]) ?>
        </div>
    </div>
</div>

<script>
    // Função para atualizar os valores mínimo e máximo do slider
    function updateRangeValues() {
        var minValue = document.getElementById('preco_min_range').value;
        var maxValue = document.getElementById('preco_max_range').value;

        // Mostrar os valores no console do navegador para depuração
        console.log('Preço Mínimo: ', minValue);
        console.log('Preço Máximo: ', maxValue);

        // Atualiza os campos de texto na interface
        document.getElementById('preco_min_value').textContent = minValue;
        document.getElementById('preco_max_value').textContent = maxValue;

        // Atualiza os valores dos campos ocultos para envio no formulário
        document.getElementById('preco_min').value = minValue;
        document.getElementById('preco_max').value = maxValue;
    }
</script>
