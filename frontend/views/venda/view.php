<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Venda */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'ORDER #' . $model->codigo;
?>
<div class="venda-view">
    <div class="mt-6 mx-5">
        <h2><strong><?= Html::encode($this->title) ?></strong></h2>
        <h4><strong><?= Yii::$app->formatter->asDate($model->datavenda, 'dd/MM/yyyy') ?></strong></h4><br>
        <h3><strong><?= $model->getLinhavendas()->count() ?> ITEMS </strong></h3>


                <?= ListView::widget([
                    'dataProvider' => $dataProvider,  // Passa o dataProvider com as Linhasvendas
                    'itemView' => '_venda',
                    'layout' => '<div class="row mt-4 gap-4">{items}</div>{pager}',
                    'options' => ['class' => 'list-view '],
                    'itemOptions' => ['class' => 'col-4 card pl-3 py-3 ', 'style' => 'max-width: 400px; max-height: 350px'],
                    'pager' => [
                        'class' => \yii\bootstrap5\LinkPager::class,
                        'options' => ['class' => 'pagination justify-content-center'],
                    ],
                ]) ?>


        <!-- Shipping e Summary -->
        <div class="row mt-4">
            <!-- Info SHIPPING -->
            <div class="col-12 col-md-4">
                <div class="card p-3 mb-2">
                    <h3 class="card-title"><strong>SHIPPING</strong></h3>
                    <h5><strong>SHIPPING ADDRESS</strong></h5>
                    <p><?= Html::encode($model->morada ?? 'Morada desconhecida') ?></p>
                    <p><?= Html::encode($model->codigopostal ?? 'Código postal desconhecido') ?>
                        <?= Html::encode($model->cidade ?? 'Cidade desconhecida') ?></p>
                    <p><?= Html::encode($model->pais ?? 'País desconhecido') ?></p>
                    <h5><strong>CARRIER</strong></h5>
                    <p><?= Html::encode($model->metodoExpedicao->nome ?? 'Transportadora desconhecida') ?></p>
                </div>
            </div>

            <!-- SUMMARY -->
            <div class="col-12 col-md-8">
                <div class="card p-3 mb-2">
                    <h3 class="card-title"><strong>TOTAL: <?= Yii::$app->formatter->asCurrency($model->total, 'EUR') ?></strong</h3>
                    <p><strong>SUBTOTAL:</strong> 999€</p>
                    <p><strong>DISCOUNT:</strong> 0€ (0%)</p>
                    <p><strong>SHIPPING:</strong> 0€ (0%)</p>
                    <hr>
                    <h3 class="text-end"><strong>TOTAL: <?= Yii::$app->formatter->asCurrency($model->total, 'EUR') ?></strong></h3>
                </div>
            </div>
        </div>
    </div>
</div>



