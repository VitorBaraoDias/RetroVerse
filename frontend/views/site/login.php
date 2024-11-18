<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Log In';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <div class="login-container">
        <div class="login-banner">
            <img src="<?= Yii::getAlias('@web') ?>/img/login/login-banner.jpeg">
        </div>
        <div class="login-content">
            <div class="login-form">
                <div class="login-header">
                    <img src="<?= Yii::getAlias('@web') ?>/img/login/login-retroverse-logo.png">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <form action="#">
                    <div class="input-details">
                        <label for="login-email">Email Address</label>
                        <input id="login-email" type="text">
                    </div>

                    <div class="input-details">
                        <label for="login-password">Password</label>
                        <input id="login-password" type="text">
                    </div>

                    <div class="input-details">
                        <button type="submit" class="btn btn-login">Log In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
