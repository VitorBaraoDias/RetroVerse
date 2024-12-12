<?php

use common\models\Estadoencomenda;
use common\models\Venda;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\VendaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Vendas';
$this->params['breadcrumbs'][] = $this->title;
$estados = \yii\helpers\ArrayHelper::map(Estadoencomenda::find()->all(), 'id', 'descricao');

?>
<div class="venda-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $form = ActiveForm::begin([
        'action' => ['update-estado-encomenda'], // Define a ação que processará o formulário
        'method' => 'post',
    ]);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model) {
            // Define a cor da linha com base no estado final
            if ($model->estadoEncomenda->isFinalState()) {
                return ['style' => 'background-color: #d4edda;']; // Verde claro para concluído
            }
            return ['style' => 'background-color: #ff929c;']; // Vermelho claro para em andamento
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'idestadoencomenda',
                'label' => 'Estado da Encomenda',
                'format' => 'raw',
                'value' => function ($model) use ($estados) {
                    // Renderiza o dropdown para edição
                    return Html::dropDownList(
                        "Vendas[{$model->id}][idestadoencomenda]",
                        $model->idestadoencomenda,
                        $estados,
                        ['class' => 'form-control']
                    );
                },
                'filter' => $estados, // Para filtro no cabeçalho da coluna
            ],
            [
                'attribute' => 'idcomprador',
                'label' => 'Comprador',
                'value' => function ($model) {
                    return $model->comprador->username ?? 'N/A';
                },
            ],
            [
                'attribute' => 'idmetodoexpedicao',
                'label' => 'Método de Expedição',
                'value' => function ($model) {
                    return $model->metodoExpedicao->nome ?? 'N/A';
                },
            ],
            'total',
            'datavenda',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}', // Apenas os botões "View" e "Delete"
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fas fa-eye"></i>', // Ícone de olho
                            $url,
                            ['title' => 'View', 'class' => 'btn btn-primary btn-sm']
                        );
                    },

                ],
            ],
        ],
    ]);

    // Botão para submeter as alterações
    echo Html::submitButton('Salvar Alterações', ['class' => 'btn btn-success']);

    ActiveForm::end();
    ?>



</div>
