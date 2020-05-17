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
                    <li class="breadcrumb-item"><a href="/mail/inbox">Входящие</a></li>
                    <li class="breadcrumb-item active">Новое сообщение</li>
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
                            <div class="col-12">
                                <div class="card-body">
                                    <h3 class="card-title">Новое сообщение</h3>
                                    <form id="internal-mail-form" action="/mail/send" method="post">
                                    <div class="form-group">
                                        <input id="receiver-field" class="form-control" placeholder="Кому:" required name="receiver">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Тема:" required name="subject">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="textarea_editor form-control" rows="20" placeholder="Текст сообщения ..." required name="message"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success m-t-20"><i class="fa fa-envelope-o"></i> Отправить</button>
                                    <button class="btn btn-inverse m-t-20"><i class="fa fa-times"></i> Отмена</button>
                                    </form>
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

<script>
    //поиск получателей
    window.addEventListener('load', function() {
        document.querySelector('#internal-mail-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = event.target;

            form.submit();
        });

        const doneTypingInterval = 1000;  //time in ms (5 seconds)
        const receiverInputField = document.querySelector('#receiver-field');

        let typingTimer;                //timer identifier

        autocomplete({
            input: receiverInputField,
            minLength: 1,
            fetch: function(text, update) {
                clearTimeout(typingTimer);

                if (receiverInputField.value.length > 2) {
                    typingTimer = setTimeout(function() {
                        $.ajax({
                            url: '/mail/receiver/search',
                            method: 'GET',
                            dataType: 'json',
                            data: 'request=' + encodeURI(text),
                            success: function(data){
                                update(data);
                            },
                            error: function() {
                                $.toast({
                                    heading: 'Ошибка получения данных',
                                    text: 'Не удалось подгрузить с сервера список ФИО пользователей',
                                    position: 'bottom-right',
                                    loaderBg:'#ff6849',
                                    icon: 'error',
                                    hideAfter: 2000
                                });
                            }
                        });
                    }, doneTypingInterval);
                }
            },
            onSelect: function(item) {
                receiverInputField.value = item.label;
            }
        });
    });
</script>