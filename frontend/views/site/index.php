
<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
?>

<!-- Hero Section Begin -->
<section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="<?= Yii::getAlias('@web') ?>/img/banner_home_1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h2>WINTER DROP</h2>
                                <p>Our latest winter drop is already available</p>
                                <a href="#" class="primary-btn btn_banner">SHOP NOW<span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="<?= Yii::getAlias('@web') ?>/img/banner_home_2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h2>ADIDAS VINTAGE WINDBREAKERS</h2>
                                <p>Our new Adidas Vintage Windbreakers are now available in our store!</p>
                                <a href="#" class="primary-btn btn_banner">SHOW NOW <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
<article class="container" style="margin-top: 45px;">
    <h2 class="text-center fw-bolder mb-4 " style="font-weight: bold;">LATEST DROPS</h2>
        <!-- Card 1 -->
        <?= ListView::widget([
            'dataProvider' => $dataProvider1,
            'itemView' => '_artigo_card',  // Especifica o arquivo de item que criamos
            'layout' => '<div class="row">{items}</div>{pager}',  // Layout com items e paginação
            'options' => ['class' => 'list-view'],  // Classe opcional para estilização adicional
            'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 card-product'],  // Estilo para cada item
            'pager' => [
                'class' => \yii\bootstrap5\LinkPager::class,
                'options' => ['class' => 'pagination justify-content-center'],
            ],
        ]) ?>
    </div>
</article>

<section class="hero" style="margin-top: 45px;">
    <div class="hero__slider owl-carousel">
        <div class="hero__items set-bg" data-setbg="<?= Yii::getAlias('@web') ?>/img/banner_home_1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>Summer Collection</h6>
                            <h2>Fall - Winter Collections 2030</h2>
                            <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                commitment to exceptional quality.</p>
                            <a href="#" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                            <div class="hero__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero__items set-bg" data-setbg="<?= Yii::getAlias('@web') ?>/img/banner_home_2.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h2>ADIDAS VINTAGE WINDBREAKERS</h2>
                            <p>Our new Adidas Vintage Windbreakers are now available in our store!</p>
                            <a href="#" class="primary-btn btn_banner">SHOW NOW <span class="arrow_right"></span></a>
                            <div class="hero__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section S>

    <!-- Banner Section End -->
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


<!-- Product Section Begin -->
    <!-- Product Section End -->


</html>