<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;


/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>
<div class="banner-collection">
    <div class="banner-collection-text">COLLECTION</div>
</div>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'],
                'options' => ['class' => ''],
            ]); ?>
            <div class="ml-3 mb-3 collection-span-texts">
                <h2 style="font-weight:700">FILTERS</h2>
            </div>


            <div class="ml-3 mb-3 collection-span-texts">
                <?= $form->field($searchModel, 'nome')->textInput([
                    'class' => 'form-control',
                    'placeholder' => 'Search by Name',
                ])->label(false) ?>
            </div>


            <?= $form->field($searchModel, 'idcategoria')->dropDownList(
                ArrayHelper::map(\common\models\Categoriaartigo::find()->all(), 'id', 'nome'),
                [
                    'prompt' => 'SELECT A CATEGORY',
                    'class' => 'ml-3 mb-3 filter-dropdown',
                    'options' => [
                        '' => ['disabled' => true, 'selected' => true], // Garante que o prompt esteja desabilitado e selecionado por padrão
                    ],
                ]
            )->label(false) ?>

            <?= $form->field($searchModel, 'idtamanho')->dropDownList(
                ArrayHelper::map(\common\models\Tamanho::find()->all(), 'id', 'tamanho'),
                [
                    'prompt' => ' SELECT A SIZE',
                    'class' => 'ml-3 mb-3 filter-dropdown',
                    'options' => [
                        '' => ['disabled' => true, 'selected' => true],
                    ],
                ]
            )->label(false) ?>

            <?= $form->field($searchModel, 'idestado')->dropDownList(
                ArrayHelper::map(\common\models\Estado::find()->all(), 'id', 'descricao'),
                [
                    'prompt' => 'SELECT A CONDITION',
                    'class' => 'ml-3 mb-3 filter-dropdown',
                    'options' => [
                        '' => ['disabled' => true, 'selected' => true],
                    ],
                ]
            )->label(false) ?>

            <?= $form->field($searchModel, 'idmarca')->dropDownList(
                ArrayHelper::map(\common\models\Marca::find()->all(), 'id', 'nome'),
                [
                    'prompt' => 'SELECT A BRAND',
                    'class' => 'ml-3 mb-3 filter-dropdown',
                    'options' => [
                        '' => ['disabled' => true, 'selected' => true],
                    ],
                ]
            )->label(false) ?>

            <div class="preco_range-container rounded p-3 mb-3">
                <label class="collection-span-texts  w-100" for="preco_range">PRICE</label>
                <div class="range-filter-card ">
                    <input class="w-100" type="range" id="preco_range" class="form-range" name="SearchArtigo[preco_min]"
                           min="0" max="1000" step="10"
                           value="<?= isset($searchModel->preco_min) ? $searchModel->preco_min : 0 ?>"
                           oninput="updateRangeDisplay(this.value)">
                </div>

                <div class="range-button-text-colection d-flex justify-content-between mt-2">
                    <span class="collection-span-texts" id="range_min_display"><?= isset($searchModel->preco_min) ? $searchModel->preco_min : 0 ?></span>
                    <span class="collection-span-texts">TO</span>
                    <span class="collection-span-texts" id="range_max_display"><?= isset($searchModel->preco_max) ? $searchModel->preco_max : 1000 ?></span>
                </div>

                <input type="hidden" id="range_min" name="SearchArtigo[preco_min]" value="<?= isset($searchModel->preco_min) ? $searchModel->preco_min : 0 ?>">
                <input type="hidden" id="range_max" name="SearchArtigo[preco_max]" value="<?= isset($searchModel->preco_max) ? $searchModel->preco_max : 1000 ?>">
            </div>



            <div class="mt-3">
                <button style="padding: 10px 5px; font-weight:700" type="submit" id="retroverse-btn-active" class="btn retroverse-btn active">SEARCH</button>
            </div>

            <?php ActiveForm::end(); ?>
        </div>


        <div class="col-md-9">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_artigo_card',
                'viewParams' => [
                    'isPremium' => $isPremium,
                ],
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
    function updateRangeDisplay(value) {
        const maxPrice = 1000;
        const minPrice = value;

        document.getElementById('range_min_display').textContent = minPrice;
        document.getElementById('range_max_display').textContent = maxPrice;

        document.getElementById('range_min').value = minPrice;
        document.getElementById('range_max').value = maxPrice;

        console.log("Preço mínimo: ", minPrice);
        console.log("Preço máximo: ", maxPrice);
    }
</script>

