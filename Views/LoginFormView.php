<section id="wrapper">
    <div class="login-register authorization">
        <div class="login-box card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Вход в личный кабинет</h4>
            </div>

            <div class="card-body">

                <form class="form-horizontal " id="loginform" action="/user/login" method="post">

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <p class="text-muted">Для входа в личный кабинет используйте логин и пароль, указанные при регистрации</p>
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
                            <input type="password" class="form-control" id="pwd" placeholder="" required name="pwd" value="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 font-14">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Запомнить меня </label>
                            </div> <a href="#" id="to-recover" class="text-dark pull-right">Забыли пароль?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-md col-5 btn-block align-baseline text-uppercase waves-effect waves-light" type="submit">Войти</button>
                            <button class="btn btn-danger btn-md col-5 btn-block align-baseline text-uppercase waves-effect waves-light"  onclick="location.href = '/';">Отмена</button>
                        </div>
                    </div>
                </form>

                <form class="form-horizontal" id="recoverform" action="/user/recover" method="post">

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <p class="text-muted">Введите Email-адрес, указанный при регистрации, для получения инструкций по восстановлению пароля </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-3 control-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-9 input-group">
                            <div class="input-group-addon"><i class="ti-email"></i></div>
                            <input type="email" class="form-control" id="email" placeholder="" required name="email" value="<?=htmlspecialchars($_POST['email'])?>">
                        </div>
                    </div>


                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-md col-5 btn-block text-uppercase waves-effect waves-light" type="submit">Отправить</button>
                            <button type="reset" id="to-login" class="btn btn-danger btn-md col-5 btn-block align-baseline text-uppercase waves-effect waves-light">Отмена</button>
                        </div>
                    </div>
                </form>

                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <div>Еще не зарегистрированы? <a href="/user/register/form" class="text-info m-l-5"><b>Регистрация</b></a></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>