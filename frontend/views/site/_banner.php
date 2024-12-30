<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \app\models\Banner $model */
?>

<div class="hero__items set-bg" data-setbg="<?= Yii::getAlias('@web/uploads/img-banners/') . $model->caminhoimagem ?>" style="background-image: url('<?= Yii::getAlias('@web/uploads/img-banners/') . $model->caminhoimagem ?>');">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-7 col-md-8">
                <div class="hero__text">
                    <h2><?= Html::encode($model->titulo) ?></h2>
                    <p><?= Html::encode($model->descricao) ?></p>
                    <?php if ($model->link): ?>
                        <a href="<?= Url::to($model->link) ?>" class="primary-btn btn_banner"><?= Html::encode($banner->textobotao ?: 'SHOP NOW') ?><span class="arrow_right"></span></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
