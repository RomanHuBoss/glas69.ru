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
                <h3 class="text-themecolor">Внутренняя почта</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <li class="breadcrumb-item active">Входящие</li>
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-xlg-2 col-lg-3 col-md-4">
                                <div class="card-body inbox-panel">
                                    <a href="/mail/send/form" class="btn btn-danger m-b-20 btn-block waves-effect waves-light">Новое сообщение</a>
                                    <ul class="list-group list-group-full">
                                        <li class="list-group-item active"> <a href="/mail/inbox"><i class="mdi mdi-gmail"></i> Входящие
                                                <? if ($data['internalMailStats']['inbox_new'] > 0) :?>
                                                    <span class="badge badge-success ml-auto"><?=$data['internalMailStats']['inbox_new']?></span>
                                                <? endif; ?>
                                            </a></li>
                                        <li class="list-group-item "><a href="/mail/outbox"> <i class="mdi mdi-file-document-box"></i> Исходящие </a></li>
                                    </ul>
                                    <h3 class="card-title m-t-40">Категории</h3>
                                    <div class="m-b-10">
                                        <span class="fa fa-circle text-info m-r-10"></span>Из списка контактов</a>
                                    </div>
                                    <div class="m-b-10">
                                        <span class="fa fa-circle text-warning m-r-10"></span>Модераторы</a>
                                    </div>
                                    <div class="m-b-10">
                                        <span class="fa fa-circle text-danger m-r-10"></span>Прочие пользователи</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xlg-10 col-lg-9 col-md-8 bg-light-part b-l">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-10 btn-group m-b-10" aria-label="Button group with nested dropdown">
                                            <a href="/mail/inbox" class="btn btn-secondary m-r-10 m-b-10"><i class="mdi mdi-reload font-18"></i> Обновить</a>
                                            <button type="button " class="btn btn-secondary m-r-10 m-b-10"><i class="mdi mdi-check font-18"></i> Выделить все</button>
                                            <button type="button" class="btn btn-secondary "><i class="mdi mdi-delete"></i> Удалить</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-t-0">
                                    <div class="card b-all shadow-none">
                                        <div class="inbox-center table-responsive">
                                            <table class="table table-hover no-wrap">
                                                <tbody>

                                                <? foreach ($data['messages'] as $message): ?>

                                                <tr class="unread">
                                                    <td style="width:40px">
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="checkbox<?=$message->getId();?>" value="<?=$message->getId();?>">
                                                            <label for="checkbox<?=$message->getId();?>"></label>
                                                        </div>
                                                    </td>
                                                    <td style="width:40px" class="hidden-xs-down"><i class="fa fa-circle
                                                    <? if ($message->isSenderInContacts()): ?>
                                                        text-info
                                                    <? elseif ($message->isSenderIsAdmin()): ?>
                                                        text-warning
                                                     <? else: ?>
                                                        text-danger
                                                    <? endif; ?>
                                                    "></i></td>
                                                    <td class="hidden-xs-down"><a href="/user/profile/<?=$message->getIdSender();?>"><?=htmlspecialchars($message->getSenderFio());?></a></td>
                                                    <td class="max-texts"> <a href="/mail/show/<?=$message->getId();?>">
                                                            <? if (trim($message->getTimeReceived()) == ''): ?>
                                                                <span class="label label-primary m-r-10">Новое</span>
                                                            <? endif;?>
                                                            <?=htmlspecialchars($message->getSubject()); ?>
                                                        </a></td>
                                                    <td class="text-right"><?=$message->getTimeCreated();?></td>
                                                </tr>

                                                <? endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
