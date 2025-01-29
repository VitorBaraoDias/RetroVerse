<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="premium-banner">
    <div class="premium-banner-text">
        <p>GET EXCLUSIVE ITEMS</p>
        <p>FOR EXCLUSIVE PRICES</p>
    </div>
</div>
<div class="premium-container">
    <div class="premium-container-titles">
        <h5>SUBSCRIBE TO PREMIUM</h5>
        <h2>EXCLUSIVE PERKS FOR PREMIUM USERS</h2>
    </div>
    <p class="premium-description">Join our Premium Membership today and gain access to exclusive drops only available to premium members.<br>
        Say goodbye to extra fees—premium users enjoy  a seamless experience with no additional charges on top of the premium content.<br>
        Elevate your experience, enjoy special offers, and access the best our platform has to offer.</p>

    <div class="premium-plan">
        <div class="premium-label">PREMIUM PLAN</div>
        <h2>PREMIUM</h2>
        <div class="d-flex justify-content-center align-items-center gap-2 position-relative mb-4">
            <p class="premium-price">€<?= round($plano->precomensal * (1 + ($plano->iva->percentagem / 100)), 2) ?></p>
            <span class="position-absolute" style="top: 70px">With IVA</span>
            <h3 class="">€<?= Html::encode($plano->precomensal) ?></h3>
        </div>
        <a href="<?= Url::to(['clientesplano/create', 'idplano' => $plano->id]) ?>" class="premium-btn">Get Started</a>
        <div class="premium-features">
            <h3>Features</h3>
            <p>GET ACCESS TO PREMIUM DROPS </p>
            <p>NO EXTRA FEES ON ALL STORE ITEMS</p>
            <p>SHIPPING PRIORITY</p>
        </div>
    </div>
</div>
