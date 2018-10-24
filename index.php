<?php

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Task;

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

if(!empty($_POST)){
    $task = new Task();
    $task->name = $_POST['name'];
    $task->save();
}
?>
<!doctype html>
<html lang="ES_es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP - Uso de ORM Eloquent</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
<h1>Uso de ORM</h1>
<h2>Agregar una tarea</h2>
<form method="post">
    <label>
        <input type="text" name="name">
    </label>
    <button type="submit">Guardar</button>
</form>
</body>
</html>