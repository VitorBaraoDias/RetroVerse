<?php

use common\models\Favorito;
use common\models\Perfil;
use yii\bootstrap5\Html;

$userId = Yii::$app->user->id;
$perfil = Perfil::findOne(['id' => $userId]);

//verificar se ele tem premium
$isPremiumActive = $perfil ? $perfil->hasActivePremiumPlano() : false;
$carrinho = \common\models\Carrinho::findOne(['iduser' => Yii::$app->user->id]);
$favoritosCount = Favorito::getFavoritosCount(Yii::$app->user->id);

?>

        <header class="container-fluid container-header">
                    <div class="header__logo">
                        <a href="<?= Yii::getAlias('@web/site/signup') ?>"><img src="<?= Yii::getAlias('@web') ?>/img/retroverse-logo.svg" alt=""></a>
                    </div>

                    <nav class="header__menu ">
                        <ul>
                            <li>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>"
                                   class="<?= (Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'index') ? 'active' : '' ?>">
                                    HOME
                                </a>
                            </li>
                            <li>
                                <a href="<?= Yii::$app->urlManager->createUrl(['artigo/index']) ?>"

                                   class="<?= (Yii::$app->controller->id === 'collection' && Yii::$app->controller->action->id === 'index') ? 'active' : '' ?>">
                                    COLLECTION
                                </a>
                            </li>
                            <li>
                                <a href="<?= Yii::$app->urlManager->createUrl(['plano/index']) ?>"
                                   class="<?= (Yii::$app->controller->id === 'plano' && Yii::$app->controller->action->id === 'index') ? 'active' : '' ?>">
                                    PREMIUM
                                </a>
                            </li>
                            <li>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/about']) ?>"
                                   class="<?= (Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'about') ? 'active' : '' ?>">
                                    ABOUT US
                                </a>
                            </li>
                            <li>
                                <a href="<?= Yii::$app->urlManager->createUrl(['faqs/index']) ?>"
                                   class="<?= (Yii::$app->controller->id === 'faqs' && Yii::$app->controller->action->id === 'index') ? 'active' : '' ?>">
                                    FAQ
                                </a>
                            </li>
                        </ul>
                        <?php if (!Yii::$app->user->isGuest) { ?>

                        <?= Html::a('+ PUBLISH AN ITEM', ['artigo/create'], [
                            'class' => 'btn retroverse-btn  w-auto px-3 py-2 rounded-0',
                            'id' => 'retroverse-btn-active',
                            'style' => 'font-size: x-small; gap: 10px',
                        ]) ?>
                        <?php }?>
                        <div class="navbar__icons">
                            <?php if (Yii::$app->user->isGuest) { ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/signup']) ?>">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/myaccount.svg" alt=""></a>
                            <?php } else { ?>

                                <a href="<?= Yii::$app->urlManager->createUrl(['chat/index']) ?> " style="position: relative">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/vector-chat.svg" alt="">
                                </a>
                                <a href="<?= Yii::$app->urlManager->createUrl(['favorito/index']) ?> " style="position: relative">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/favourites.svg" alt="">
                                    <div id="info-cart">
                                        <?= $favoritosCount ? $favoritosCount : 0 ?>
                                    </div>
                                </a>
                                <a href="<?= Yii::$app->urlManager->createUrl(['carrinho/index']) ?>" style="position: relative">
                                    <img src="<?= Yii::getAlias('@web') ?>/img/cart.svg" alt="">
                                    <div id="info-cart">
                                        <?= $carrinho ? $carrinho->getLinhascarrinhos()->count() : 0 ?>
                                    </div>
                                </a>
                                <?php if ($isPremiumActive) { ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['perfil/index', 'id' => Yii::$app->user->id]) ?>"><img src="<?= Yii::getAlias('@web') ?>/img/myaccount-premium.svg" alt=""></a>
                                <?php } else { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['perfil/index', 'id' => Yii::$app->user->id]) ?>">
                                        <img src="<?= Yii::getAlias('@web') ?>/img/myaccount.svg" alt="My Account">
                                    </a>
                                <?php } ?>
                                <a href="<?= Yii::$app->urlManager->createUrl(['site/logout']) ?>"><img src="<?= Yii::getAlias('@web') ?>/img/logout.svg" alt=""></a>
                            <?php } ?>
                        </div>
                    </nav>

            <div class="hamburger">
                <svg xmlns="http://www.w3.org/2000/svg" id="openSideBar" width="40" height="90" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="lucide lucide-menu">
                    <line x1="4" x2="20" y1="12" y2="12" />
                    <line x1="4" x2="20" y1="6" y2="6" />
                    <line x1="4" x2="20" y1="18" y2="18" />
                </svg>
            </div>
            <div class="sidebar" id="left-bar">
                <nav class="">
                    <div>
                        <img src="/ipl-2semestre/app-retroverse/frontend/web/img/retroverse-logo.svg" alt="">
                        <svg xmlns="http://www.w3.org/2000/svg" style="color:black;float: right;
                margin-left: auto;cursor:pointer;" id="closeSideBar" width="40" height="90" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="lucide lucide-x">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </div>
                    <a class="switch_button_hamburguer" href="#">
                        <label for="mane_hamburguer" class="button_float_hamburguer">
                            <div class="texts_hamburguer">
                                <span class="left_hamburguer">STORE</span>
                                <span class="right_hamburguer">MARKETPLACE</span>
                            </div>
                            <input type="checkbox" name="mane_hamburguer" id="mane_hamburguer" />
                            <div class="container_active_hamburguer"></div>
                        </label>
                    </a>
                    <div class="active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>" class="fw-bold text-black">HOME</a>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shirt"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/collection']) ?>"
                           class="fw-medium text-black">COLLECTION</a>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gem"><path d="M6 3h12l4 6-10 13L2 9Z"/><path d="M11 3 8 9l4 13 4-13-3-6"/><path d="M2 9h20"/></svg>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/premium']) ?>"
                           class="fw-medium">PREMIUM</a>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/aboutus']) ?>"
                           class="fw-medium">ABOUT US</a>

                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-help"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/faq']) ?>"
                           class="fw-medium">FAQ</a>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/></svg>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/favourites']) ?>"
                           class="fw-medium">FAVOURITES</a>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>                        <a href="<?= Yii::$app->urlManager->createUrl(['site/cart']) ?>"
                           class="fw-medium ">MY CART</a>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round"><path d="M18 20a6 6 0 0 0-12 0"/><circle cx="12" cy="10" r="4"/><circle cx="12" cy="12" r="10"/></svg>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/profile']) ?>"
                           class="fw-medium ">MY ACCOUNT</a>
                    </div>
                </nav>
            </div>
        </header>

</div>
