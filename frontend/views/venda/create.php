<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var \common\models\Venda $model */

$this->title = 'CHECKOUT';

?>
<div class="venda-create">

    <h1 CLASS="text-center" style="font-weight: bolder"><?= Html::encode($this->title) ?></h1>
    <div class="row justify-content-between mt-4">
        <div class="col-md-6 px-4">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    <div class="col-md-5 d-flex flex-column gap-4 card p-4" style="    height: fit-content;
">
        <h2 class="text-center"><strong> ORDER SUMMARY </strong></h2>
        <hr>
            <?= ListView::widget([
                'dataProvider' => new ActiveDataProvider(['query' => $carrinho->getLinhascarrinhos()]),
                'itemView' => '_carrinho',
                'layout' => '<div class="row justify-content-center mt-4 gap-4">{items}</div>{pager}',
                'options' => ['class' => 'list-view'],
                'itemOptions' => ['class' => 'col-12  p-2 d-flex flex-column justify-content-between'],
                'pager' => [
                    'class' => \yii\bootstrap5\LinkPager::class,
                    'options' => ['class' => 'pagination justify-content-center'],
                ],
            ]) ?>
        <hr>
        <div class="d-flex justify-content-between">
            <h2 class="text-center"><strong>TOTAL:</strong></h2>
            <h2><strong>
                    <?= Yii::$app->formatter->asCurrency($carrinho->getTotalVenda(), 'EUR') ?>
                </strong>
            </h2>
        </div>


    </div>
</div>
</div>
<?php
$script = <<< JS
$('#country-input').on('input', function() {
    let selectedCountry = $(this).val(); 
    let countryCode = null;
    alert('ola')
    $('#country-list option').each(function() {
        if ($(this).val() === selectedCountry) {
            countryCode = $(this).data('code');
        }
    });

    $('#city-list').empty();

    if (countryCode) {
        $.getJSON('/country/get-cities?countryCode=' + countryCode, function(data) {
            $.each(data, function(index, city) {
                $('#city-list').append('<option value="' + city + '"></option>');
            });
        }).fail(function() {
            console.error('Erro ao obter as cidades para o país: ' + countryCode);
        });
    }
});
JS;
$this->registerJs($script);
?>

