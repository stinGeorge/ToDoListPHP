<?php
$post = $_POST;

var_dump($post);
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
    <input type="text" name="name">
    <button type="submit">Guardar</button>
</form>
</body>
</html>