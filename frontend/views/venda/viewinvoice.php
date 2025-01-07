<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Perfil;

/* @var $this yii\web\View */
/* @var $model common\models\Venda */
/* @var $dataProvider yii\data\ActiveDataProvider */

$userId = Yii::$app->user->id;
$perfil = Perfil::findOne(['id' => $userId]);

//verificar se ele tem premium
$isPremium = $perfil ? $perfil->hasActivePremiumPlano() : false;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Invoice - Order #<?= Html::encode($model->codigo ?? 'Order Desconhecida') ?></h1>
        </div>
    </section>


    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>RETROVERSE <small class="float-right">Date: <?= Yii::$app->formatter->asDate($model->datavenda, 'dd/MM/yyyy') ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Retroverse, Inc.</strong><br>
                    Rua de Leiria nº10<br>
                    Leiria, 2470-360<br>
                    Email: info@retroverse.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong> <?= Html::encode($model->nome ?? 'Nome Desconhecido') ?></strong><br>
                      <?= Html::encode($model->morada ?? 'Morada desconhecida') ?><br>
                      <?= Html::encode($model->codigopostal ?? 'Código postal desconhecido') ?>
                      <?= Html::encode($model->cidade ?? 'Cidade desconhecida') ?><br>
                    Email: <?= Html::encode($model->comprador->user->email ?? 'Cidade desconhecida') ?>
                  </address>
                </div>
                <div class="col-sm-4 invoice-col">
                  <br>
                  <b>Order ID:</b> #<?= Html::encode($model->codigo ?? 'Order Desconhecida') ?><br>
                  <b>User Account:</b> @<?= Html::encode($model->comprador->user->username ?? 'User desconhecido') ?>
                </div>
              </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Description</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
              <!-- Table Body -->
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,  // Passa o dataProvider com as Linhasvendas
                    'itemView' => '_invoice_items',
                    'viewParams' => [
                        'isPremium' => $isPremium,
                    ],
                    'layout' => '<div class="row mt-4 gap-4">{items}</div>{pager}',
                    'options' => ['class' => 'list-view '],
                    'pager' => [
                        'class' => \yii\bootstrap5\LinkPager::class,
                        'options' => ['class' => 'pagination justify-content-center'],
                    ],
                ]) ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>€<?= Html::encode($model->getOrderSubtotal($isPremium) ?? 'Valor desconhecido') ?></td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>€<?= Html::encode($model->total ?? 'Valor desconhecido') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <!-- /.control-sidebar -->
</div>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
