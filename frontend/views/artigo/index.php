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
            <div class="ml-3 mb-3 collection-span-texts">
                <h2 style="font-weight:700">FILTERS</h2>
            </div>


            <!-- Nome do Artigo -->
            <div class="ml-3 mb-3 collection-span-texts">
                <?= $form->field($searchModel, 'nome')->textInput([
                    'class' => 'form-control',
                    'placeholder' => 'Pesquisar por nome',
                ])->label(false) ?>
            </div>


            <!-- CATEGORY Filter -->
            <?= $form->field($searchModel, 'idcategoria')->dropDownList(
                ArrayHelper::map(\common\models\Categoriaartigo::find()->all(), 'id', 'nome'),
                [
                    'prompt' => 'SELECIONE A CATEGORIA',
                    'class' => 'ml-3 mb-3 filter-dropdown',
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
                    'class' => 'ml-3 mb-3 filter-dropdown',
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
                    'class' => 'ml-3 mb-3 filter-dropdown',
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
                    'class' => 'ml-3 mb-3 filter-dropdown',
                    'options' => [
                        '' => ['disabled' => true, 'selected' => true],
                    ],
                ]
            )->label(false) ?>

            <div class="preco_range-container rounded p-3 mb-3">
                <label class="collection-span-texts  w-100" for="preco_range">PREÇO</label>
                <!-- Slider único -->
                <div class="range-filter-card ">
                    <input class="w-100" type="range" id="preco_range" class="form-range" name="SearchArtigo[preco_min]"
                           min="0" max="1000" step="10"
                           value="<?= isset($searchModel->preco_min) ? $searchModel->preco_min : 0 ?>"
                           oninput="updateRangeDisplay(this.value)">
                </div>

                <!-- Exibição dos valores mínimo e máximo -->
                <div class="range-button-text-colection d-flex justify-content-between mt-2">
                    <span class="collection-span-texts" id="range_min_display"><?= isset($searchModel->preco_min) ? $searchModel->preco_min : 0 ?></span>
                    <span class="collection-span-texts">até</span>
                    <span class="collection-span-texts" id="range_max_display"><?= isset($searchModel->preco_max) ? $searchModel->preco_max : 1000 ?></span>
                </div>

                <!-- Campos ocultos para envio -->
                <input type="hidden" id="range_min" name="SearchArtigo[preco_min]" value="<?= isset($searchModel->preco_min) ? $searchModel->preco_min : 0 ?>">
                <input type="hidden" id="range_max" name="SearchArtigo[preco_max]" value="<?= isset($searchModel->preco_max) ? $searchModel->preco_max : 1000 ?>">
            </div>



            <!-- Search Button -->
            <div class="mt-3">
                <button style="padding: 10px 5px; font-weight:700" type="submit" id="retroverse-btn-active" class="btn retroverse-btn active">SEARCH</button>
            </div>

            <?php ActiveForm::end(); ?>
        </div>


        <div class="col-md-9">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_artigo_card',
                'layout' => '<div class="row">{items}</div>{pager}',
                'options' => ['class' => 'list-view'],
                'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 card-product mt-4'],
                'pager' => [
                    'class' => \yii\bootstrap5\LinkPager::class,
                    'options' => ['class' => 'pagination justify-content-center'],
                ],
            ]) ?>
        </div>
    </div>
</div>

<script>
    // Atualizar os valores do range slider
    function updateRangeDisplay(value) {
        const maxPrice = 1000; // Valor máximo fixo do slider
        const minPrice = value; // Valor mínimo ajustado no slider

        // Atualiza os elementos de exibição
        document.getElementById('range_min_display').textContent = minPrice;
        document.getElementById('range_max_display').textContent = maxPrice;

        // Atualiza os campos ocultos do formulário
        document.getElementById('range_min').value = minPrice;
        document.getElementById('range_max').value = maxPrice;

        // Debug no console
        console.log("Preço mínimo: ", minPrice);
        console.log("Preço máximo: ", maxPrice);
    }
</script>

