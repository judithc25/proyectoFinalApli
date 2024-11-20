<?php
/*
session_start();
if (!isset($_SESSION['usuario'])) {
    // Redirigir al inicio de sesión si no está autenticado
    header("Location: iniciar_sesion.php");
    exit;
}
    */
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="shortcut icon" href="./imagenes/favicon.png" type="image/x-icon">

  </head>
  <div class="navbar">
    <img src="./imagenes/librosapi.png" alt="libros" >
    <h1><b>Libby</b></h1>
    <a href="Inventario.html">Inventario</a>
    <a href="Libros.html">Libros</a>
    </div>
  <body>
    <h1>Mi Perfil</h1>
  </body>
</html>