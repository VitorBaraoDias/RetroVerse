<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Venda $model */

$this->title = 'Order details for '. $model->comprador->username;
$this->params['breadcrumbs'][] = ['label' => 'Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="venda-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Date',
                'value' => Yii::$app->formatter->asDate($model->datavenda, 'long'), // Formata a data
            ],
            [
                'label' => 'Buyer',
                'value' => $model->comprador->username ?? 'N/A', // Acessa o nome do comprador
            ],
            [
                'label' => 'Order status',
                'format' => 'raw', // Permite HTML
                'value' => function ($model) {
                    $status = $model->estadoEncomenda->descricao ?? 'N/A';
                    $color = $model->estadoEncomenda->isFinalState() ? 'green' : 'orange'; // Verde para concluído, laranja para andamento
                    return Html::tag('span', $status, ['style' => "color: $color; font-weight: bold;"]);
                },
            ],
            [
                'label' => 'Shipping method',
                'value' => $model->metodoExpedicao->nome ?? 'N/A', // Nome do método de expedição
            ],
            [
                'label' => 'Type of payment',
                'value' => $model->tipopagamento->descricao ?? 'N/A', // Tipo de pagamento
            ],
            [
                'label' => 'Name',
                'value' => $model->nome, // Nome da pessoa ou encomenda
            ],
            [
                'label' => 'Country',
                'value' => $model->pais, // País
            ],
            [
                'label' => 'City',
                'value' => $model->cidade, // Cidade
            ],
            [
                'label' => 'Address',
                'value' => $model->morada, // Endereço completo
            ],
            [
                'label' => 'Postcode',
                'value' => $model->codigopostal, // Código postal
            ],
            [
                'label' => 'Total',
                'value' => Yii::$app->formatter->asCurrency($model->total), // Formata o total como moeda
            ],
        ],
    ]) ?>
    <?=
     GridView::widget([
        'dataProvider' =>
        new ActiveDataProvider(['query' => $model->getLinhavendas()]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // Coluna serial

            [
                'attribute' => 'primeiraFoto',
                'label' => 'Foto',
                'format' => 'raw',
                'value' => function ($model) {
                    $firstPhoto = $model->idartigo0->fotosartigos[0] ?? null;
                    if ($firstPhoto && file_exists('../../common/uploads/img-artigos/' . $firstPhoto->caminhofoto)) {
                        return Html::img(('../../../common/uploads/img-artigos/'). $firstPhoto->caminhofoto, [
                            'alt' => 'Article Image',
                            'class' => 'img-thumbnail',
                            'style' => 'width: 370px; height: 270px; object-fit: cover;',
                        ]);
                    } else {
                        // Se não houver imagem, exibir uma div cinza
                        return Html::tag('div', '', [
                            'class' => 'img-thumbnail',
                            'style' => 'width: 150px; height: 150px; background-color: grey; display: flex; align-items: center; justify-content: center;',
                        ]);
                    }
                },
            ],
            [
                'attribute' => 'nome',
                'label' => 'Nome',
                'value' => function ($model) {
                    return $model->idartigo0->nome ?? 'N/A';
                },
            ],
            [
                'attribute' => 'marca',
                'label' => 'Marca',
                'value' => function ($model) {
                    return $model->idartigo0->idmarca0->nome ?? 'N/A'; // Acessa o nome da marca relacionada
                },
            ],
            [
                'attribute' => 'estado',
                'label' => 'Estado',
                'value' => function ($model) {
                    return $model->idartigo0->idestado0->descricao ?? 'N/A'; // Acessa o estado do artigo
                },
            ],
            [
                'attribute' => 'preco',
                'label' => 'Preço',
                'value' => function ($model) {
                    return Yii::$app->formatter->asCurrency($model->idartigo0->precoanuncio); // Formata o preço como moeda
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{details}', // Personaliza os botões de ação
                'buttons' => [
                    'details' => function ($url, $model) {

                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
