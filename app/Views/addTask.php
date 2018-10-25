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
<h1>Uso de ORM Eloquent</h1>
<h2>Agregar una tarea</h2>
<form method="post" action="/projects/php/tasks/add">
    <label>
        <input type="text" name="name">
    </label>
    <button type="submit">Agregar</button>
</form>
<a href="/projects/php/">Ver lista de tareas</a>
</body>
</html>