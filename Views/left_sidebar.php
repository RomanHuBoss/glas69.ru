<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar"   id="logo-background">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img"> <img src="/assets/images/megaphone_logo.jpg" alt="Информационная система Глас Народа"/>
                <!-- this is blinking heartbit-->
                <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
            </div>
            <!-- User profile text-->
            <div class="profile-text">
                <img src="/assets/images/logo-glas-text.png" alt="Информационная система Глас Народа" class="dark-logo" />
                <h5>Тверская область</h5>
            </div>
        </div>
        <!-- End User profile text-->

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <? if (!$data['currentUser']->getIsGuest()): ?>
                    <li class="nav-small-cap"><strong>КАБИНЕТ ПОЛЬЗОВАТЕЛЯ</strong></li>

                    <li> <a class="waves-effect waves-dark" href="/user/profile/<?=$data['currentUser']->getId();?>" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Мой профиль</span></a></li>

                    <li> <a class="waves-effect waves-dark" href="/mail/inbox" aria-expanded="false"><i class="ti-email "></i><span class="hide-menu">Внутренняя почта</span>
                            <? if ($data['internalMailStats']['inbox_new'] > 0) :?>
                                <span class="badge badge-success ml-auto"><?=$data['internalMailStats']['inbox_new']?></span>
                            <? endif; ?>
                        </a></li>
                    <li> <a class="waves-effect waves-dark" href="/user/cabinet/appeals" aria-expanded="false"><i class="ti-announcement "></i><span class="hide-menu">Мои обращения</span></a></li>
                    <li> <a class="waves-effect waves-dark" href="/user/cabinet/appeals" aria-expanded="false"><i class="ti-plus"></i><span class="hide-menu">Новое обращение</span></a></li>
                    <li> <a class="waves-effect waves-dark" href="/user/cabinet/friends" aria-expanded="false"><i class="icon-people"></i><span class="hide-menu">Список контактов</span></a></li>
                <? else: ?>
                    <li class="nav-small-cap"><strong>ГОСТЕВОЙ ДОСТУП</strong></li>
                    <li> <a class="waves-effect waves-dark" href="/user/login/form" aria-expanded="false"><i class="icon-login"></i><span class="hide-menu">Вход в кабинет</span></a></li>
                    <li> <a class="waves-effect waves-dark" href="/user/register/form" aria-expanded="false"><i class="icon-user-follow"></i><span class="hide-menu">Регистрация</span></a></li>
                <?php endif; ?>

                <li class="nav-small-cap"><strong>ОФИЦИАЛЬНО</strong></li>
                <li> <a class="waves-effect waves-dark" href="/common/official/news" aria-expanded="false"><i class="icon-feed "></i><span class="hide-menu">Новости региона</span></a></li>
                <li> <a class="waves-effect waves-dark" href="/common/official/plans" aria-expanded="false"><i class="ti-time "></i><span class="hide-menu">Планы развития</span></a></li>
                <li> <a class="waves-effect waves-dark" href="/common/official/authorities" aria-expanded="false"><i class=" ti-flag-alt-2 "></i><span class="hide-menu">Органы власти</span></a></li>
                <li> <a class="waves-effect waves-dark" href="/common/official/resources" aria-expanded="false"><i class=" ti-world "></i><span class="hide-menu">Интернет-ресурсы</span></a></li>

                <li class="nav-small-cap"><strong>О ПРОЕКТЕ</strong></li>
                <li> <a class="waves-effect waves-dark" href="/common/terms" aria-expanded="false"><i class="ti-files "></i><span class="hide-menu">Условия использования</span></a></li>
                <li> <a class="waves-effect waves-dark" href="/common/faq" aria-expanded="false"><i class=" icon-question "></i><span class="hide-menu">Вопрос-ответ</span></a></li>
                <li> <a class="waves-effect waves-dark" href="/common/team" aria-expanded="false"><i class="icon-badge "></i><span class="hide-menu">Команда проекта</span></a></li>
                <li> <a class="waves-effect waves-dark" href="/common/feedback/form" aria-expanded="false"><i class="ti-comments "></i><span class="hide-menu">Обратная связь</span></a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
