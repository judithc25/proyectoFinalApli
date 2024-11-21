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
    <h3>___________________________________________________________________________________</h3>
    <div class="card" style="background-color:#D1C4E9">
                    <div class="card-header" style="background-color:#B39DDB">
                        Mis datos personales
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead class="table-success" >
                                <tr>
                                    <th style="background-color:#B39DDB">Id</th>
                                    <th style="background-color:#B39DDB">Nombre</th>
                                    <th style="background-color:#B39DDB">Apellido</th>
                                    <th style="background-color:#B39DDB">Direccion</th>
                                    <th style="background-color:#B39DDB">Ciudad</th>
                                    <th style="background-color:#B39DDB">Estado</th>
                                    <th style="background-color:#B39DDB">Correo</th>
                                    <th style="background-color:#B39DDB">Telefono</th>
                                    <th style="background-color:#B39DDB">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaMiperfil">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card" style="background-color:#D1C4E9">
                    <div class="card-header" style="background-color:#B39DDB">
                        Mis compras
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead class="table-success" >
                                <tr>
                                    <th style="background-color:#B39DDB">Nombre Libro</th>
                                    <th style="background-color:#B39DDB">Autor</th>
                                    <th style="background-color:#B39DDB">Cantidad</th>
                                    <th style="background-color:#B39DDB">fecha compra</th>
                                    <th style="background-color:#B39DDB">direccion de envio</th>
                                    <th style="background-color:#B39DDB">Total</th>
                                </tr>
                            </thead>
                            <tbody id="tablaMiperfil">
                              
                            </tbody>
                        </table>
                    </div>
                </div>
  </body>
</html>