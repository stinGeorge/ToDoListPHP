<?php
// Show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;
use Zend\Diactoros\Response\RedirectResponse;

session_start();

$dotEnv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotEnv->load();

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
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
    'action' => 'indexAction',
));

// Routes for Login
$map->get('indexLogin', '/login/', array(
    'controller' => 'App\Controllers\AuthController',
    'action' => 'indexAction'
));
$map->post('authLogin', '/login/', array(
    'controller' => 'App\Controllers\AuthController',
    'action' => 'authLogin'
));
$map->get('authLogout', '/logout/', array(
    'controller' => 'App\Controllers\AuthController',
    'action' => 'authLogout'
));
$map->get('indexAdmin', '/admin/', array(
    'controller' => 'App\Controllers\AdminController',
    'action' => 'index',
    'auth' => true
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

//    echo $routerContainer->getGenerator()->generate('indexUser');
if(!$route){
    echo 'This is not a valid route';
}else{
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $controllerAction = $handlerData['action'];

    $needsAuth = $handlerData['auth'] ?? false;
    $sessionUserID = $_SESSION['userID'] ?? null;

    if($needsAuth && !$sessionUserID){
        $controller = new \App\Controllers\AuthController();
        $response = $controller->authLogout();
    }else{
        $controller = new $handlerData['controller'];
        $response = $controller->$controllerAction($request);
    }

    foreach ($response->getHeaders() as $name => $values){
        foreach ($values as $value){
            header(sprintf('%s: %s', $name, $value), false);
        }
    }
    http_response_code($response->getStatusCode());

    echo $response->getBody();
}