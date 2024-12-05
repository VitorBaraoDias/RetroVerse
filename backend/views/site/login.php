<?php
use yii\helpers\Html;
?>
<div class="card w-100" >
    <div class="card-body login-card-body">
        <p class="login-box-msg fs-3 fw-semibold">Sign in to start your session</p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model,'username', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '<div class="icheck-primary d-flex align-items-center gap-2">{input}{label}</div>',
                    'labelOptions' => [
                        'class' => ''
                    ],
                    'uncheck' => null
                ]) ?>
        </div>
        <div>
            <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block mt-4 w-100']) ?>

        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>


        <!-- /.social-auth-links -->

        <p class="mb-1 text-center mt-4">
            <a href="forgot-password.html">I forgot my password</a>
        </p>
        <p class="mb-0 text-center">
            <?= Html::a('Register a new membership', ['site/signup']) ?>

        </p>
    </div>
    <!-- /.login-card-body -->
</div>