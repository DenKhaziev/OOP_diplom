<?php
namespace app\controllers;
//use Aura\SqlQuery\QueryFactory;
//use DI\ContainerBuilder;
//use League\Plates\Engine;
//use Psr\Container\ContainerInterface;
//use Delight\Auth\Auth;
use FastRoute;


require '../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/php/Diplom_OOP/reg', ['app\controllers\HomeController', 'registerView']);
    $r->addRoute('POST', '/php/Diplom_OOP/reg/done', ['app\controllers\HomeController', 'registration']);
    $r->addRoute('GET', '/php/Diplom_OOP/verify', ['app\controllers\HomeController', 'verify']);
    $r->addRoute('GET', '/php/Diplom_OOP/login', ['app\controllers\HomeController', 'loginView']);
    $r->addRoute('POST', '/php/Diplom_OOP/login/done', ['app\controllers\HomeController', 'login']);
    $r->addRoute('GET', '/php/Diplom_OOP/logout', ['app\controllers\HomeController', 'logout']);
    $r->addRoute('GET', '/php/Diplom_OOP/getRole', ['app\controllers\HomeController', 'getRoles']);
    $r->addRoute('GET', '/php/Diplom_OOP/assignRole', ['app\controllers\HomeController', 'assignRole']);
    $r->addRoute('GET', '/php/Diplom_OOP/users', ['app\controllers\HomeController', 'users']);
    $r->addRoute('GET', '/php/Diplom_OOP/edit{id:\d+}', ['app\controllers\HomeController', 'editUserView']);
    $r->addRoute('POST', '/php/Diplom_OOP/edit/done/{id:\d+}', ['app\controllers\HomeController', 'editUser']);
    $r->addRoute('GET', '/php/Diplom_OOP/status{id:\d+}', ['app\controllers\HomeController', 'editStatusView']);
    $r->addRoute('POST', '/php/Diplom_OOP/status/done/{id:\d+}', ['app\controllers\HomeController', 'editStatus']);
    $r->addRoute('GET', '/php/Diplom_OOP/media{id:\d+}', ['app\controllers\HomeController', 'editAvatarView']);
    $r->addRoute('POST', '/php/Diplom_OOP/media/done/{id:\d+}', ['app\controllers\HomeController', 'imgUpload']);
    $r->addRoute('GET', '/php/Diplom_OOP/delete/{id:\d+}', ['app\controllers\HomeController', 'deleteUser']);
    $r->addRoute('GET', '/php/Diplom_OOP/create_user', ['app\controllers\HomeController', 'createUserView']);
    $r->addRoute('POST', '/php/Diplom_OOP/create_user/done', ['app\controllers\HomeController', 'createUser']);
    $r->addRoute('GET', '/php/Diplom_OOP/security{id:\d+}', ['app\controllers\HomeController', 'changePasswordView']);
    $r->addRoute('POST', '/php/Diplom_OOP/security/done/{id:\d+}', ['app\controllers\HomeController', 'changePassword']);

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 404;
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $controller = new $handler[0];
        call_user_func([$controller, $handler[1]], $vars); // идем в контроллер (передаем именно новый экземпляр класса - $controller, вызываем метод который идет с $handler[1] и передаем параметры $vars
        break;
}