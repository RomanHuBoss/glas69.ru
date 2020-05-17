
<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto mt-md-0">
                <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>

                <li>
                    <h2 class="site-title-div">Региональная информационная система интернет-референдумов</h2>
                </li>
            </ul>


            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                    <form class="app-search">
                        <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                </li>
                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?=$data['currentUser']->getAvatar()?>" alt="<?=$data['currentUser']->getFio()?>" class="profile-pic" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="<?=$data['currentUser']->getAvatar()?>" alt="<?=$data['currentUser']->getFio()?>"></div>
                                    <div class="u-text">
                                        <h4><strong><?= $data['currentUser']->getFioShorten(); ?></strong></h4>
                                        <? if (!$data['currentUser']->getIsGuest()): ?>
                                            <p class="text-muted"><?=$data['currentUser']->getEmail();?></p>
                                        <? endif;?>
                                        <p class="text-muted"><?=$data['currentUser']->getIp();?> / <?=$data['currentUser']->getBrowserShorten();?></p>
                                    </div>
                            </li>
                            <? if (!$data['currentUser']->getIsGuest()): ?>
                                <li role="separator" class="divider"></li>
                                <li><a href="/user/logout"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Выход</a></li>
                            <? else: ?>
                                <li role="separator" class="divider"></li>
                                <li><a href="/user/login/form"><i class="icon-login"></i>&nbsp;&nbsp;Вход</a></li>
                                <li><a href="/user/register/form"><i class="icon-user-follow"></i>&nbsp;&nbsp;Регистрация</a></li>
                            <? endif; ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->

