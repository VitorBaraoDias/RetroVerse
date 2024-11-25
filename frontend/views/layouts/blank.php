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
    <title>RetroVerse | Login</title>

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

<body>

<?php $this->beginBody() ?>

<main role="main" class="flex-shrink-0">

        <?= $content ?>
</main>


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
