<?php

use kartik\file\FileInput;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Perfil $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="perfil-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <!-- Primeira Coluna: Imagem -->
        <div class="col-md-6 text-center">
            <div id="image-container" style="cursor: pointer;">
                <!-- Imagem inicial ou padrão -->
                <img class="rounded-circle"
                     id="profile-image"
                     src="<?= empty($model->caminhofotoperfil)
                         ? Yii::getAlias('@web') . '/img/icon-profile.svg'
                         : Yii::getAlias('@web') . '/uploads/img-profile/' . $model->caminhofotoperfil ?>"
                     alt="Foto de Perfil"
                     style="max-height: 280px; object-fit: cover"
                     width="280">
            </div>
            <!-- Input file oculto -->
            <?= $form->field($uploadForm, 'imageFile')->fileInput([
                'id' => 'file-input',
                'accept' => 'image/*',
                'style' => 'display: none;', // Ocultar o input file
            ])->label(false); ?>
        </div>

        <!-- Segunda Coluna: Detalhes -->
        <div class="col-md-6">
            <div class="input-details">
                <?= $form->field($model, 'descricao')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Enter your description'
                ])->label('Description'); ?>
            </div>
            <div class="input-details">
                <?= $form->field($model, 'morada')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Enter your address'
                ])->label('Location'); ?>
            </div>
        </div>
    </div>

    <!-- Botão de Confirmação -->
    <div class="form-group d-flex justify-content-end mt-4">
        <?= Html::submitButton('CONFIRM', ['class' => 'btn retroverse-btn active w-auto px-5 py-2', 'id' => "retroverse-btn-active"]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<!-- JavaScript para Interação -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageContainer = document.getElementById('image-container');
        const profileImage = document.getElementById('profile-image');
        const fileInput = document.getElementById('file-input');

        // Clique no container da imagem para abrir o input file
        imageContainer.addEventListener('click', function () {
            fileInput.click();
        });

        // Atualizar a imagem ao selecionar um arquivo
        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    profileImage.src = e.target.result; // Carregar a nova imagem
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
