<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper register-wrapper">
    <div class="login-register registration">
        <div class="login-box card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?=$data['title']?></h4>
            </div>

            <div class="card-body">
                <form class="form-horizontal " id="loginform" action="/user/register" method="post">

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <p class="text-muted">Все поля формы обязательны для заполнения</p>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="fio" class="col-sm-3 control-label">ФИО <span class="text-danger">*</span></label>
                        <div class="col-sm-9 input-group">
                            <div class="input-group-addon"><i class="fa fa-id-card-o"></i></div>
                            <input type="text" class="form-control id="fio" placeholder="" required name="fio" value="<?=htmlspecialchars($_POST['fio'])?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="login" class="col-sm-3 control-label">Логин <span class="text-danger">*</span></label>
                        <div class="col-sm-9 input-group">
                            <div class="input-group-addon"><i class="ti-user"></i></div>
                            <input type="text" class="form-control" id="login" placeholder="" required name="login" value="<?=htmlspecialchars($_POST['login'])?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pwd1" class="col-sm-3 control-label">Пароль <span class="text-danger">*</span></label>
                        <div class="col-sm-9 input-group">
                            <div class="input-group-addon"><i class="ti-lock"></i></div>
                            <input type="password" class="form-control" id="pwd1" placeholder="" required name="pwd1" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pwd2" class="col-sm-3 control-label">Подтверждение <span class="text-danger">*</span></label>
                        <div class="col-sm-9 input-group">
                            <div class="input-group-addon"><i class="ti-lock"></i></div>
                            <input type="password" class="form-control" id="pwd2" placeholder="" required name="pwd2" value="">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="email" class="col-sm-3 control-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-9 input-group">
                            <div class="input-group-addon"><i class="ti-email"></i></div>
                            <input type="email" class="form-control" id="email" placeholder="" required name="email" value="<?=htmlspecialchars($_POST['email'])?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-sm-3 control-label">Адрес <span class="text-danger">*</span></label>
                        <div class="col-sm-9 input-group">
                            <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                            <input type="text" class="form-control fias-field" data-search-disabled='1'
                                   id="address" placeholder="" required name="address" list="reg-addresses" value="<?=htmlspecialchars($_POST['address'])?>">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-sm-3 control-label">Пол <span class="text-danger">*</span></label>
                        <div class="col-sm-9 input-group">
                            <div class="input-group-addon"><i class="mdi mdi-gender-male-female"></i></div>
                            <select class="form-control custom-select" id="gender" name="gender" required>
                                    <option value="м" <?if ($_POST['gender'] == 'м'):?> selected <?endif?> >Мужской</option>
                                    <option value="ж" <?if ($_POST['gender'] == 'ж'):?> selected <?endif?> >Женский</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="address" class="col-sm-3 control-label">Дата рождения <span class="text-danger">*</span></label>
                        <div class="col-sm-9 input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="birth_date" value="<?=$_POST['birth_date']?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-success">
                                <input id="checkbox-signup" type="checkbox" name="terms_agree" >
                                <label for="checkbox-signup"> Я соглашаюсь с <a href="/common/terms">Условиями использования</a></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-md col-5 btn-block align-baseline text-uppercase waves-effect waves-light" type="submit">Отправить</button>
                            <button class="btn btn-danger btn-md col-5 btn-block align-baseline text-uppercase waves-effect waves-light"  onclick="location.href = '/';">Отмена</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <div>Уже есть учетная запись? <a href="/user/login/form" class="text-info m-l-5"><b>Войти</b></a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    //работа с ФИАС полями
    window.addEventListener('load', function() {
        document.querySelector('#loginform').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = event.target;
            const checkBox = document.querySelector('#checkbox-signup');
            if (!checkBox.checked) {
                swal("Ошибка", "Необходимо согласиться с Условиями использования ИС \"Глас народа\".", "error")
                return;
            }

            form.submit();
        });

        const doneTypingInterval = 1000;  //time in ms (5 seconds)
        const fiasInputFields = document.querySelectorAll('input.fias-field');

        fiasInputFields.forEach((fiasInputField) => {
            let typingTimer;                //timer identifier

            autocomplete({
                input: fiasInputField,
                minLength: 1,
                fetch: function(text, update) {
                    clearTimeout(typingTimer);

                    if (fiasInputField.value.length > 2) {
                        typingTimer = setTimeout(function() {
                            $.ajax({
                                url: '/common/fias/search',
                                method: 'GET',
                                dataType: 'json',
                                data: 'request=' + encodeURI(text),
                                success: function(data){
                                    update(data);
                                },
                                error: function() {
                                    $.toast({
                                        heading: 'Ошибка получения данных',
                                        text: 'Не удалось подгрузить с сервера адреса из ФИАС',
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
                    fiasInputField.value = item.label;
                }
            });
        });
    });
</script>