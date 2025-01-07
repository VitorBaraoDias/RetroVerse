<?php

use common\models\Perfil;
use hail812\adminlte\widgets\Menu;
use yii\helpers\Url;

if (!Yii::$app->user->isGuest) {
    $userId = Yii::$app->user->id;
    $perfil = Perfil::findOne(['id' => $userId]);
}

$items = [
    [
        'label' => 'Dashboard',
        'icon' => 'fa-solid fa-file-invoice',
        'url' => ['site/index'],
        'active' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'index',
    ],
];

if (Yii::$app->user->can('verAbaStoreBackend')) {
    $items[] = [
        'label' => 'Store',
        'icon' => 'fa-solid fa-store',
        'items' => [
            ['label' => 'Orders', 'url' => ['linhavenda/index'], 'iconStyle' => 'far'],
            ['label' => 'Items', 'url' => ['artigo/index'], 'iconStyle' => 'far'],
            ['label' => 'Plans', 'url' => ['plano/index'], 'iconStyle' => 'far'],
            ['label' => 'Categories', 'url' => ['categoriaartigo/index'], 'iconStyle' => 'far'],
            ['label' => 'Brands', 'url' => ['marca/index'], 'iconStyle' => 'far'],
            ['label' => 'Sizes', 'url' => ['tamanho/index'], 'iconStyle' => 'far'],
            ['label' => 'Conditions', 'url' => ['estado/index'], 'iconStyle' => 'far'],
        ],
    ];
}

$items[] = [
    'label' => 'MarketPlace',
    'icon' => 'fa-solid fa-users',
    'items' => [
        ['label' => 'Item Reports', 'url' => ['denuncia/index'], 'iconStyle' => 'far'],
    ],
];

if (Yii::$app->user->can('verAbaGeneralBackend')) {
    $items[] = [
        'label' => 'General',
        'icon' => 'fa-solid fa-hammer',
        'items' => [
            ['label' => 'Store Banner', 'url' => ['banner/index'], 'iconStyle' => 'far'],
            ['label' => 'Shipping methods', 'url' => ['metodosexpedicao/index'], 'iconStyle' => 'far'],
            ['label' => 'FAQS', 'url' => ['faqs/index'], 'iconStyle' => 'far'],
            ['label' => 'Users', 'url' => ['user/index'], 'iconStyle' => 'far'],
            ['label' => 'IVA', 'url' => ['iva/index'], 'iconStyle' => 'far'],
            ['label' => 'Comission', 'url' => ['comissao/index'], 'iconStyle' => 'far'],
        ],
    ];
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Url::to(['site/index']); ?>" class="brand-link">
        <span class="brand-text font-weight-light">RetroVerse</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php if (!empty($perfil->caminhofotoperfil)): ?>
                    <img src="<?= Yii::getAlias('@web') ?>/../../common/uploads/img-profile/<?= $perfil->caminhofotoperfil ?>" class="img-circle elevation-2" alt="User Image">
                <?php else: ?>
                    <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                <?php endif; ?>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= Menu::widget([
                'items' => $items,
            ]); ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
