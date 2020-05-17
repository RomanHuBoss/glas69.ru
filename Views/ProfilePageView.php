<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <? include "topbar_header.php"; ?>

    <? include "left_sidebar.php"; ?>


    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles m-b-30">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Профиль пользователя</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Профиль</li>
                </ol>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <!-- Row -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <center class="m-t-30"> <img src="<?=$data['profileOwner']->getAvatar()?>" class="img-circle" width="150" />
                                <h4 class="card-title m-t-10"><?=htmlspecialchars($data['profileOwner']->getFioShorten());?></h4>
                                <h6 class="card-subtitle">ОАО "НПП "Эргоцентр"</h6>
                                <div class="row text-center justify-content-md-center">
                                    <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                                    <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                                </div>
                            </center>
                        </div>
                        <div>
                            <hr>
                        </div>
                        <div class="card-body"> <small class="text-muted">Email</small>
                            <h6><a href="mailto:<?=htmlspecialchars($data['profileOwner']->getEmail());?>"><?=htmlspecialchars($data['profileOwner']->getEmail());?></a></h6>
                            <small class="text-muted p-t-30 db">Телефон</small>
                            <h6>+7 (910) 649-54-**</h6>
                            <small class="text-muted p-t-30 db">Адрес</small>
                            <div class="map-box" id="mapid" class="w-12" style="height: 150px"></div>

                            <script>
                                window.addEventListener('load', function() {
                                    const map = L.map('mapid').setView([57.341715, 36.045027], 7);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                    }).addTo(map);
                                    const marker = L.marker([57.341715, 36.045027]).addTo(map);
                                });
                            </script>

                            <small class="text-muted p-t-30 db">Социальные сети</small>
                            <br/>
                            <button class="btn btn-circle btn-secondary"><i class="fa fa-facebook"></i></button>
                            <button class="btn btn-circle btn-secondary"><i class="fa fa-twitter"></i></button>
                            <button class="btn btn-circle btn-secondary"><i class="fa fa-youtube"></i></button>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card  h-100">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 b-r"> <strong>ФИО</strong>
                                    <br>
                                    <p class="text-muted"><?=htmlspecialchars($data['profileOwner']->getFio());?></p>
                                </div>
                                <div class="col-md-3 b-r"> <strong>Роль</strong>
                                    <br>
                                    <p class="text-muted"><?=$data['profileOwner']->getUserTypeStrRus()?></p>
                                </div>
                                <div class="col-md-3 b-r"> <strong>Дата рождения</strong>
                                    <br>
                                    <p class="text-muted"><?=date('d-m-Y', strtotime($data['profileOwner']->getBirthDate()))?></p>
                                </div>
                                <div class="col-md-3"> <strong>Последний визит</strong>
                                    <br>
                                    <p class="text-muted"><?=date('d-m-Y')?></p>
                                </div>
                            </div>
                            <hr>
                            <p class="m-t-30"><?=$data['profileOwner']->getAbout()?></p>

                            <? if ($data['profileOwner']->getLogin() == 'roman'): ?>
                            <h4 class="font-medium m-t-30">Компетенции</h4>
                            <hr>
                            <h5 class="m-t-30">Agile (Scrum) <span class="pull-right">70%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%; height:6px;"> <span class="sr-only">70% Complete</span> </div>
                            </div>
                            <h5 class="m-t-30">PHP 5/7 <span class="pull-right">70%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%; height:6px;"> <span class="sr-only">70% Complete</span> </div>
                            </div>
                            <h5 class="m-t-30">JavaScript <span class="pull-right">80%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%; height:6px;"> <span class="sr-only">70% Complete</span> </div>
                            </div>
                            <h5 class="m-t-30">HTML 5 <span class="pull-right">90%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%; height:6px;"> <span class="sr-only">50% Complete</span> </div>
                            </div>
                            <h5 class="m-t-30">C++ <span class="pull-right">60%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:60%; height:6px;"> <span class="sr-only">60% Complete</span> </div>
                            </div>
                            <h5 class="m-t-30">PostgreSQL <span class="pull-right">70%</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%; height:6px;"> <span class="sr-only">70% Complete</span> </div>
                            </div>

                            <?endif;?>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
            <!-- Row -->

            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->

        <? include "common_footer.php"; ?>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
