<div class="d-flex gap-4 justify-content-between align-items-center">
    <div class="d-flex gap-3">
        <?php use yii\bootstrap5\Html;

        if (!empty($model->remetente->caminhofotoperfil)): ?>
            <img class="rounded-circle mb-4" style="object-fit: cover; height: 30px; width: 30px"
                 src="<?= Yii::getAlias('@web') ?>/uploads/img-profile/<?= $model->remetente->caminhofotoperfil ?>" alt="Foto de Perfil">
        <?php else: ?>
            <img src="<?= Yii::getAlias('@web') ?>/img/icon-profile.svg" alt="Ícone de Perfil" height="140">
        <?php endif; ?>
        <div class="d-flex flex-column">
            <span><?= $model->remetente->user->username ?></span>
            <div class="d-flex">
                <span><?= $model->escala ?></span>
                <img src="<?= Yii::getAlias('@web/img/star.svg') ?>" alt="Star Icon" style="height: 20px; margin-left: 10px;">
            </div>
            <span><?= $model->descricao ?></span>
        </div>
    </div>
    <div>
        <?php
        $firstPhoto = $model->linhavenda->idartigo0->fotosartigos[0] ?? null;
        $imagePath = Yii::getAlias('@web/uploads/img-artigos/') . ($firstPhoto->caminhofoto ?? '');

        if ($firstPhoto && file_exists(Yii::getAlias('@frontend/web/uploads/img-artigos/') . $firstPhoto->caminhofoto)) {
            echo Html::img($imagePath, [
                'alt' => 'Article Image',
                'class' => '',
                'style' => ' height: 50px; width: 50px; object-fit: cover;',
            ]);
        } else {
            echo Html::tag('div', '', [
                'class' => 'img-thumbnail',
                'style' => 'width: 50px; height: 50px; background-color: grey; display: flex; align-items: center; justify-content: center;',
            ]);
        }
        ?>
    </div>
</div>