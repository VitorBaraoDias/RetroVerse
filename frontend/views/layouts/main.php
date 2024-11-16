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
            <div class="col-lg-3 col-md-12 col-sm-12 pr-5">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="#"><img src="<?= Yii::getAlias('@web') ?>/img/retroverse-logo.svg" alt=""></a>
                    </div>
                    <a href="#"><img src="<?= Yii::getAlias('@web') ?>/img/footer/payments.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="footer__widget">
                    <h6>NAVIGATION</h6>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Collection</a></li>
                        <li><a href="#">Plans</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="footer__widget">
                    <h6>MARKETPLACE</h6>
                    <ul>
                        <li><a href="#">Collection</a></li>
                        <li><a href="#">Sell an Item</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="footer__widget">
                    <h6>LEGAL</h6>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>

                    </ul>
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
