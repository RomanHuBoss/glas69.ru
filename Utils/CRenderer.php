<?php


namespace Glas\Utils;


class CRenderer
{
    function getTitleViewName($viewName) {
        $titles = [
            'RegisterFormView' => 'Регистрация пользователя',
            'LoginFormView' => 'Вход в личный кабинет',
            'MainPageView'     => 'Главная',
        ];
        return $titles[$viewName];
    }

    function render($viewName, $data = []) {
        if (!$data['title']) {
            $data['title'] = $this->getTitleViewName($viewName);
        }

        if (!is_null($data['currentUser'])) {
            $data['internalMailStats'] = $data['currentUser']->getInternalMailStats();
        }

        include $_SERVER['DOCUMENT_ROOT'].'/Views/header.php';
        include $_SERVER['DOCUMENT_ROOT'].'/Views/'.$viewName.'.php';
        include $_SERVER['DOCUMENT_ROOT'].'/Views/footer.php';
    }
}