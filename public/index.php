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

$routerContainer = new RouterContainer('/projects/php');
$map = $routerContainer->getMap();

// Index principal - Front Controller
$map->get('index', '/', array(
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
));

// Routes for Login
$map->get('indexLogin', '/login-form/', array(
    'controller' => 'App\Controllers\AuthController',
    'action' => 'indexAction'
));
$map->post('auth', '/auth/', array(
    'controller' => 'App\Controllers\AuthController',
    'action' => 'authLogin'
));

// Routes for tasks
$map->get('indexTask', '/tasks/', array(
    'controller' => 'App\Controllers\TaskController',
    'action' => 'indexAction'
));
$map->get('addTask', '/tasks/add/',  array(
    'controller' => 'App\Controllers\TaskController',
    'action' => 'addAction'
));
$map->post('saveTask', '/tasks/add/',  array(
    'controller' => 'App\Controllers\TaskController',
    'action' => 'addAction'
));

// Routes for users
$map->get('indexUser', '/users/', array(
    'controller' => 'App\Controllers\UserController',
    'action' => 'indexAction'
));
$map->get('addUser', '/users/add/',  array(
    'controller' => 'App\Controllers\UserController',
    'action' => 'addAction'
));
$map->post('saveUser', '/users/add/',  array(
    'controller' => 'App\Controllers\UserController',
    'action' => 'addAction'
));

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);
if(!$route){
    echo 'This is not valid route';
}else{
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $controllerAction = $handlerData['action'];
    $controller = new $handlerData['controller'];
    $response = $controller->$controllerAction($request);
    echo $response->getBody();
}