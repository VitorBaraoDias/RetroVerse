<?php

use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>
<div class="avaliacao-index container" style="width: 750px">

    <div class="card px-4 py-4">
        <div class="row" style="height: 500px">
            <div class="col-md-6 d-flex flex-column" style="height: 100%; position: relative;">
                <h2 class="text-center" style="position: absolute; top: 0; width: 100%;"><strong>FOLLOWERS</strong></h2>
                <div class="info-user d-flex flex-column align-items-center justify-content-center" style="flex-grow: 1; margin-top: 50px;">
                    <?php if (!empty($perfil->caminhofotoperfil)): ?>
                        <img class="rounded-circle mb-4 mt-4" style="object-fit: cover; height: 200px; width: 200px"
                             src="<?= Yii::getAlias('@web') ?>/uploads/img-profile/<?= $perfil->caminhofotoperfil ?>" alt="Foto de Perfil">
                    <?php else: ?>
                        <img src="<?= Yii::getAlias('@web') ?>/img/icon-profile.svg" alt="Ícone de Perfil" height="140">
                    <?php endif; ?>
                    <h2 class="text-center"><?= $perfil->user->username ?></h2>
                </div>
            </div>

            <div class="col-md-6">

                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_followers_card',
                    'layout' => '<div class="d-flex flex-column gap-2 overflow-auto" style="max-height: 450px;">{items}</div>{pager}',
                    'options' => ['class' => 'list-view'],
                    'itemOptions' => ['class' => 'card px-2 py-2'],
                    'pager' => [
                        'class' => \yii\bootstrap5\LinkPager::class,
                        'options' => ['class' => 'pagination justify-content-center'],
                    ],
                ]) ?>
            </div>
        </div>
    </div>

</div>
