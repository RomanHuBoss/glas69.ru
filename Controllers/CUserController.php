<?php


namespace Glas\Controllers;

use Glas\Models\CDeviceInfoModel;
use Glas\Models\CFiasModel;
use Glas\Models\CGenderModel;
use Glas\Models\CUserModel;
use Glas\Models\CUserTypeModel;
use Glas\Utils\CRenderer;

class CUserController extends CAbstractController
{
    public function __construct(CUserModel $currentUser)
    {
        parent::__construct($currentUser);
    }

    public function profile(Array $data = []) {
        $profileOwner = CUserModel::getOne($data['varData']['userId']);

        if (!$profileOwner->getId()) {
            header('Location: /');
            exit;
        }

        (new CRenderer())->render('ProfilePageView', [
            'usemap' => true,
            'title' => 'Профиль пользователя',
            'currentUser' => $this->currentUser,
            'profileOwner' => $profileOwner
        ]);
    }

    public function login(Array $data = []) {
        try {
            $userData = $_POST;

            foreach ($userData as $k=>$v) {
                $userData[$k] = trim($v);
            }

            if (!isset($userData['login']) || $userData['login'] == '') {
                throw new \Exception('Не указан логин');
            }
            else if (!isset($userData['pwd']) || $userData['pwd'] == '') {
                throw new \Exception('Не указан пароль');
            }

            $this->currentUser = CUserModel::authorize($userData['login'], $userData['pwd']);

            CDeviceInfoModel::create([
                'id_user'=> $this->currentUser->getId(),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'browser' => $_SERVER['HTTP_USER_AGENT']
            ]);

            $_SESSION['user_id'] = $this->currentUser->getId();

            header('Location: /');
            exit;
        }
        catch (\Exception $e) {
            (new CRenderer())->render('LoginFormView', [
                'currentUser' => $this->currentUser,
                'errorDialog' => ['title' => 'Ошибка', 'message' => 'Не удалось войти в кабинет. '.$e->getMessage()]
            ]);
        }
    }

    public function logout() {
        unset($_SESSION['id']);
        session_destroy();
        header('Location: /');
        exit;
    }

    public function register(Array $data = []) {
        try {
            $userData = $_POST;

            foreach ($userData as $k=>$v) {
                $userData[$k] = trim($v);
            }

            $userData['id_user_type'] = CUserTypeModel::getUserType();

            if ($userData['fio'] == '') {
                throw new \Exception('ФИО не может быть пустым');
            }

            if ($userData['login'] == '') {
                throw new \Exception('Логин не может быть пустым');
            }

            if ($userData['pwd1'] == '' || $userData['pwd2'] == '') {
                throw new \Exception('Пароль не может быть пустым');
            }

            if ($userData['pwd1'] != $userData['pwd2']) {
                throw new \Exception('Пароли не совпадают');
            }

            $userData['password'] = $userData['pwd1'];

            if ($userData['email'] == '') {
                throw new \Exception('Email не может быть пустым');
            }


            if ($userData['address'] == '') {
                throw new \Exception('Адрес не может быть пустым');
            }

            $userData['id_address'] = CFiasModel::getByFullAdress($userData['address'])['fias_code'];

            if (trim($userData['id_address']) == '') {
                throw new \Exception('Указанный адрес отсутствует в справочнике адресов');
            }

            if ($userData['gender'] == 'м') {
                $userData['id_gender'] = CGenderModel::getMaleGender();
            }
            else if ($userData['gender'] == 'ж') {
                $userData['id_gender'] = CGenderModel::getFemaleGender();
            }
            else {
                throw new \Exception('Указан некорректный пол');
            }

            if ($userData['birth_date'] == '') {
                throw new \Exception('Дата рождения не может быть пустой');
            }

            if (!preg_match('/\d{4}-\d{1,2}-\d{1,2}/is', $userData['birth_date'])) {
                throw new \Exception('Указана некорректная дата рождения');
            }

            CUserModel::create($userData);

            (new CRenderer())->render('MainPageView', [
                'currentUser' => $this->currentUser,
                'successDialog' => ['title' => 'Поздравляем!', 'message' => 'Вы успешно зарегистрировались в ИС "Глас народа"']
            ]);
        }
        catch(\Exception $e) {
            (new CRenderer())->render('RegisterFormView', [
                'currentUser' => $this->currentUser,
                'errorDialog' => ['title' => 'Ошибка', 'message' => 'Регистрация не завершена. '.$e->getMessage()]
            ]);
        }
    }

    public function registerForm(Array $data = []) {
        (new CRenderer())->render('RegisterFormView', $data);
    }

    public function loginForm(Array $data = []) {
        (new CRenderer())->render('LoginFormView', $data);
    }

}