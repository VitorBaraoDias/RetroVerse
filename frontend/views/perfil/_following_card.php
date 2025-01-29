<div class="d-flex gap-3 justify-content-between align-items-center" style="height: 40px;">
    <div class="d-flex gap-3 align-items-center">
        <?php use yii\bootstrap5\Html; ?>

        <?php if (!empty($model->idperfil0->caminhofotoperfil)): ?>
            <img class="rounded-circle" style="object-fit: cover; height: 30px; width: 30px;"
                 src="<?= Yii::getAlias('@web') ?>/uploads/img-profile/<?= $model->idperfil0->caminhofotoperfil ?>"
                 alt="Foto de Perfil">
        <?php else: ?>
            <img src="<?= Yii::getAlias('@web') ?>/img/icon-profile.svg" alt="Ícone de Perfil" height="30">
        <?php endif; ?>

        <div class="d-flex flex-column justify-content-center" style="height: 30px;">
            <span class="text-truncate"><?= $model->idperfil0->user->username ?></span>
        </div>
    </div>
</div>
