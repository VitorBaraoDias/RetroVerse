<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \common\models\Clientesplano $model */

$this->title = 'Create Clientesplano';

?>
    <div class="clientesplano-create">
        <h1 class="text-center"><strong>PREMIUM PLAN</strong></h1>
        <h2 class="text-center"><strong>SUBSCRIBE TO PREMIUM</strong> </h2>
        <div class="premium-features ">
            <p>GET ACCESS TO PREMIUM DROPS </p>
            <p>NO EXTRA FEES ON ALL STORE ITEMS</p>
            <p>SHIPPING PRIORITY</p>
        </div>
        <h2 class="text-center"><strong>€ <?= Html::encode($planoAtivo->precomensal) ?></strong></h2>
        <p class="text-center">Cancel when you want</p>


        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>


    </div>
<?php
