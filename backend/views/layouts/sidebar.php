
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">

        <img src="<?= Yii::getAlias('@web') ?>/../../public/img/logokuicly.png"  alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Kuicly</span>
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
                    ['label' => 'USER DETAILS', 'header' => true],
                    ['label' => 'User', 'url' => ['user/index'], 'icon' => 'fas fa-user'],

                    ['label' => 'COURSE DETAILS', 'header' => true],
                    ['label' => 'Course', 'url' => ['course/index'], 'icon' => 'fa-solid fa-book'],
                    //['label' => 'Quizzes', 'url' => ['site/login'], 'icon' => 'sign-in-alt'],
                    ['label' => 'Categories', 'url' => ['category/index'], 'icon' => 'fa-solid fa-list'],

                    ['label' => 'SELLS', 'header' => true],
                    ['label' => 'Orders', 'url' => ['order/index'], 'icon' => 'fa-solid fa-receipt'],
                    ['label' => 'Iva', 'url' => ['iva/index'], 'icon' => 'fa-solid fa-percent'],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>