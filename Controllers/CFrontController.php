<?php


namespace Glas\Controllers;

use Glas\Models\CUserModel;
use Glas\Utils\CRenderer;
use Glas\Utils\CRouter;
use http\Header;

class CFrontController extends CAbstractController
{
    public function __construct(CUserModel $currentUser)
    {
        parent::__construct($currentUser);
    }

    public function handleRequest() {
        $router = new CRouter();
        $route = $router->transofrmUriToRoute($_SERVER['REQUEST_URI']);

        //проверка существования маршрута
        if (empty($route)) {
            http_response_code(404);
            (new CRenderer())->render('404', ['user' => $this->currentUser, 'title' => 'Ошибка 404 - Запрашиваемый ресурс не существует']);
            exit;
        }

        //проверка типа запроса
        if (!in_array($_SERVER['REQUEST_METHOD'], $route['methods'])) {
            //http_response_code(405);
            header('Location: /');
            exit;
        }

        //если нет прав на доступ
        if (!in_array($this->currentUser->getUserTypeStr(), $route['availableTo'])) {
            //http_response_code(405);
            header('Location: /');
            exit;
        }

        $controllerName = $route['handlerData']['controllerName'];
        $controllerMethodName = $route['handlerData']['controllerMethodName'];

        new CCommonController($this->currentUser);

        (new $controllerName($this->currentUser))->$controllerMethodName($route);

    }

}