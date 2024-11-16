<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$action = Yii::$app->controller->id;

?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Retroverse second hand clothes">
    <meta name="keywords" content="Vintage clothing, retro, y2k, Retroverse, retroverse clothing">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RetroVerse | Homepage</title>

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/style.css" type="text/css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<?php $this->beginBody() ?>


<?= $this->render('navbar') ?>

<main role="main" class="flex-shrink-0">

    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="#"><img src="<?= Yii::getAlias('@web') ?>/img/footer-logo.png" alt=""></a>
                    </div>
                    <p>The customer is at the heart of our unique business model, which includes design.</p>
                    <a href="#"><img src="<?= Yii::getAlias('@web') ?>/img/payment.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Shopping</h6>
                    <ul>
                        <li><a href="#">Clothing Store</a></li>
                        <li><a href="#">Trending Shoes</a></li>
                        <li><a href="#">Accessories</a></li>
                        <li><a href="#">Sale</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Shopping</h6>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Payment Methods</a></li>
                        <li><a href="#">Delivary</a></li>
                        <li><a href="#">Return & Exchanges</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>NewLetter</h6>
                    <div class="footer__newslatter">
                        <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                        <form action="#">
                            <input type="text" placeholder="Your email">
                            <button type="submit"><span class="icon_mail_alt"></span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="footer__copyright__text">
                    <p>Copyright ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>2020
                        All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<?php $this->endBody() ?>

</body>

<!-- Js Plugins -->
<script src="<?= Yii::getAlias('@web') ?>/js/jquery-3.3.1.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/bootstrap.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/jquery.nice-select.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/jquery.nicescroll.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/jquery.magnific-popup.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/jquery.countdown.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/jquery.slicknav.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/mixitup.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/owl.carousel.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/js/main.js"></script>

</html>
