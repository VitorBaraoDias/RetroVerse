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

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <div class="input-details">
                    <?= $form->field($model, 'username')->textInput([
                            'autofocus' => true,
                        'id' => 'login-username',
                        'placeholder' => 'Enter your username'
                    ])->label('Username'); ?>
                </div>

                <div class="input-details">
                    <?= $form->field($model, 'password')->passwordInput([
                        'id' => 'login-password',
                        'placeholder' => 'Enter your password'
                    ])->label('Password'); ?>

                    <img id="login-show-password" src="<?= Yii::getAlias('@web') ?>/img/login/login-show-password.png" alt="Show Password">
                </div>

                <div class="input-details">
                    <?= Html::submitButton('Log In', ['class' => 'btn-login', 'type' => 'submit']) ?>
                </div>

                <div class="diviser"></div>

                <div class="input-details">
                    <p>No account yet? <?= Html::a('Sign Up', ['site/signup'], ['class' => 'link-login']) ?></p>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
