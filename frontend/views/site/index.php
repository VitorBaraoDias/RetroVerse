
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
?>
<script src="https://cdn.jsdelivr.net/npm/mqtt@4.2.7/dist/mqtt.min.js"></script>
<section class="hero">
    <div class="hero__slider owl-carousel owl-loaded owl-drag">
        <?php foreach ($banners as $banner): ?>
            <div class="hero__items set-bg" data-setbg="<?= Yii::getAlias('@web/uploads/img-banners/') . $banner['caminhoimagem'] ?>" style="background-image: url('<?= Yii::getAlias('@web/uploads/img-banners/') . $banner['caminhoimagem'] ?>');">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h2><?= $banner['titulo']; ?></h2>
                                <p><?=$banner['descricao']; ?></p>
                                <?php if ($banner['link']): ?>
                                    <a href="<?= Yii::getAlias('@web') . '/' . ltrim($banner['link'], '/') ?>" class="primary-btn btn_banner"><?= Html::encode($banner['textobotao'] ?: 'SHOP NOW') ?><span class="arrow_right"></span></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>


<article class="container" style="margin-top: 45px;">
    <h2 class="text-center fw-bolder mb-4 " style="font-weight: bold;">LATEST DROPS</h2>
        <!-- Card 1 -->
        <?= ListView::widget([
            'dataProvider' => $dataProvider1,
            'itemView' => '_artigo_card',
            'layout' => '<div class="row">{items}</div>{pager}',
            'options' => ['class' => 'list-view'],
            'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 card-product'],
            'pager' => [
                'class' => \yii\bootstrap5\LinkPager::class,
                'options' => ['class' => 'pagination justify-content-center'],
            ],
        ]) ?>
    </div>
</article>

<section class="hero">
    <div class="hero__slider owl-carousel owl-loaded owl-drag">
        <?php foreach ($banners as $banner): ?>
            <div class="hero__items set-bg" data-setbg="<?= Yii::getAlias('@web/uploads/img-banners/') . $banner['caminhoimagem'] ?>" style="background-image: url('<?= Yii::getAlias('@web/uploads/img-banners/') . $banner['caminhoimagem'] ?>');">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h2><?= $banner['titulo']; ?></h2>
                                <p><?=$banner['descricao']; ?></p>
                                <?php if ($banner['link']): ?>
                                    <a href="<?= Yii::getAlias('@web') . '/' . ltrim($banner['link'], '/') ?>" class="primary-btn btn_banner"><?= Html::encode($banner['textobotao'] ?: 'SHOP NOW') ?><span class="arrow_right"></span></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<article class="mb-4 container" style="margin-top: 45px;">
    <h2 class="text-center fw-bolder mb-4 " style="font-weight: bold;" >LATEST PREMIUM DROPS</h2>

    <?= ListView::widget([
        'dataProvider' => $dataProvider2,
        'itemView' => '_artigo_card_premium',
        'layout' => '<div class="row">{items}</div>{pager}',
        'options' => ['class' => 'list-view'],
        'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 card-product'],
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'options' => ['class' => 'pagination justify-content-center'],
        ],
        'viewParams' => [
            'isPremiumActive' => $isPremiumActive,
        ],
    ]) ?>

</article>



<script>
    var userId = <?= json_encode(Yii::$app->user->id) ?>;

    const client = new Paho.MQTT.Client('broker_url', Number(port), 'clientId');

    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    client.connect({ onSuccess: onConnect });

    function onConnect() {
        console.log('Connected to MQTT Broker');
        client.subscribe('notificacoes/favoritos/${userId}');
    }

    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log('Lost connection: ' + responseObject.errorMessage);
        }
    }

    function onMessageArrived(message) {
        console.log('Received message: ' + message.payloadString);
        exibirNotificacao(message.payloadString);
    }

    function exibirNotificacao(mensagem) {
        alert(mensagem);
    }


</script>
</html>
