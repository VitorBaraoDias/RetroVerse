<?php

use common\models\Linhavenda;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\LinhavendaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Store Orders';
?>
<div class="linhavenda-index">

    <!-- Filtros -->
    <div class="filter-container">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['index'], // Pode ser alterado para o controlador correto
        ]); ?>

        <!-- Filtro de estado de encomenda -->
        <?= $form->field($searchModel, 'statusFilter')->dropDownList(
            [
                'accepted' => 'Accepted',
                'completed' => 'Completed',
            ],
            ['prompt' => 'Select Status']
        )->label('Filter Order by Status') ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_artigo',
        'layout' => '<div class="row">{items}</div>{pager}',
        'options' => ['class' => 'list-view'],
        'itemOptions' => [
            'class' => 'col-md-4 mb-44' // Definindo o layout de coluna
        ],
    ]) ?>


</div>
