<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">RetroVerse</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Dashboard', 'icon' => 'fa-solid fa-file-invoice',
                        'url' => ['site/index'], 'active' => Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'index'
                    ],
                    [
                        'label' => 'Store',
                        'icon' => 'fa-solid fa-store',
                        'items' => [
                            ['label' => 'Orders', 'url' => ['orders/index'], 'iconStyle' => 'far'],
                            ['label' => 'Items', 'url' => ['items/index'], 'iconStyle' => 'far'],
                            ['label' => 'Plans', 'url' => ['plans/index'], 'iconStyle' => 'far'],
                            ['label' => 'Categories', 'url' => ['categories/index'], 'iconStyle' => 'far'],
                            ['label' => 'Brands', 'url' => ['brands/index'], 'iconStyle' => 'far'],
                            ['label' => 'Sizes', 'url' => ['brands/index'], 'iconStyle' => 'far'],
                            ['label' => 'Conditions', 'url' => ['brands/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'MarketPlace',
                        'icon' => 'fa-solid fa-users',
                        'items' => [
                            ['label' => 'Members', 'url' => ['orders/index'], 'iconStyle' => 'far'],
                            ['label' => 'Processed Orders', 'url' => ['items/index'], 'iconStyle' => 'far'],
                            ['label' => 'Reports', 'url' => ['plans/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'General',
                        'icon' => 'fa-solid fa-hammer',
                        'items' => [
                            ['label' => 'Store Banner', 'url' => ['orders/index'], 'iconStyle' => 'far'],
                            ['label' => 'Shipping methods', 'url' => ['items/index'], 'iconStyle' => 'far'],
                            ['label' => 'FAQS', 'url' => ['plans/index'], 'iconStyle' => 'far'],
                            ['label' => 'Users', 'url' => ['user/index'], 'iconStyle' => 'far'],

                        ]
                    ],
                    ['label' => 'Yii2 Tool', 'header' => true],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>