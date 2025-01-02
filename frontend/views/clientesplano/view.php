<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;

YiiAsset::register($this);

/** @var yii\web\View $this */
/** @var \common\models\Clientesplano $model */

$this->title = "Plano de Assinatura - " . $model->id;
\yii\web\YiiAsset::register($this);
?>

<div class="clientesplano-view container my-5">
    <h1 class="text-left"><strong>MY PLAN</strong></h1>

    <!-- Detalhes do Plano -->
    <div class="row justify-content-start mt-4">
        <div class="col-12"> <!-- Modificado para usar a largura total -->
            <div class="card w-100 shadow-sm">
                <div style="background:#0000FF" class="card-header">
                    <h4 style="color:white" class="card-title text-center"><b>PLAN DETAILS</b></h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-center mb-3">
                        <h5 class="mb-0 mr-2"><strong>Plan Description:</strong></h5> <!-- Remover a margem inferior do título -->
                        <p class="text-muted mb-0"><?= Html::encode($model->plano->descricao) ?></p> <!-- Remover a margem inferior do parágrafo -->
                    </div>
                    <div class="d-flex justify-content-start align-items-center mb-3">
                        <h5 class="mb-0 mr-2"><strong>Monthly Payment:</strong></h5> <!-- Remover a margem inferior do título -->
                        <p class="text-muted mb-0"><?=  Html::encode($model->plano->precomensal) ?>€</p> <!-- Remover a margem inferior do parágrafo -->
                    </div>
                    <div class="d-flex justify-content-start align-items-center">
                        <h5 class="mb-0 mr-2"><strong>Expiration Date:</strong></h5> <!-- Remover a margem inferior do título -->
                        <p class="text-muted mb-0"><?= Yii::$app->formatter->asDatetime($model->expira, 'long') ?></p> <!-- Remover a margem inferior do parágrafo -->
                    </div>

                    <!-- Botão de Cancelamento -->
                    <div class="text-left mt-4">
                        <?php
                        $form = ActiveForm::begin([
                            'action' => ['delete', 'id' => $model->id],
                            'method' => 'post',
                        ]);
                        ?>
                        <?= Html::submitButton('CANCEL PLAN', [
                                'class' => 'btn btn-danger btn-md',
                            'data' => [
                                'confirm' => 'Tem certeza de que deseja cancelar este plano?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
