<?php
// Show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'todolist',
    'username'  => 'root',
    'password'  => 'root',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/projects/php/', array(
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
));
$map->get('addTask', '/projects/php/tasks/add',  array(
    'controller' => 'App\Controllers\TaskController',
    'action' => 'addAction'
));

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);
if(!$route){
    echo 'No route <br />';
}else{
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $controllerAction = $handlerData['action'];
    $controller = new $handlerData['controller'];
    $controller->$controllerAction();
}