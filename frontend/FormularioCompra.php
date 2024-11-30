<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/Formulario.css">
    <link rel="shortcut icon" href="./imagenes/favicon.png" type="image/x-icon">

  </head>
  <div class="navbar">
    <img src="./imagenes/librosapi.png" alt="libros" >
    <h1><b>Libby</b></h1>
    <a href="inicioSesion.html">Inicio de Sesión</a>
    <a href="Libros.html">Libros</a>
    </div>
  <body>
  <form action="../src/procesar_compra.php" method="POST" class="row g-3 needs-validation" novalidate>
    <hr>
    <h3>Datos de Compra</h3>
    <div class="col-md-4 position-relative">
        <label for="usuario" class="form-label"><b>Usuario</b></label>
        <input type="text" class="form-control" id="usuario" name="usuario" required>
    </div>
    <div class="col-md-4 position-relative">
        <label for="fecha" class="form-label"><b>Fecha</b></label>
        <input type="date" class="form-control" id="fecha" name="fecha" required>
    </div>
    <div class="col-md-3 position-relative">
        <label for="cantidad" class="form-label"><b>Cantidad</b></label>
        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
    </div>
    <div class="col-md-3 position-relative">
        <label for="libro" class="form-label"><b>Nombre Libro</b></label>
        <select class="form-control" id="libro" name="libro" required>
            <option value="" disabled selected>Seleccione un libro</option>
            <?php
            require_once '../src/config/database.php';
            $database = new Database();
            $conn = $database->getConnection();
            if ($conn) {
                $query = "SELECT id_libro, name FROM libros";
                $result = $conn->query($query);
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['id_libro'] . '">' . $row['name'] . '</option>';
                }
            }
            ?>
        </select>
    </div>
        <hr>
            <h3>Datos de Tarjeta</h3>
    <div class="col-md-4 position-relative">
        <label for="nombre" class="form-label"><b>Nombre</b></label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="col-md-3 position-relative">
        <label for="nuTar" class="form-label"><b>Numero Tarjeta</b></label>
        <input type="number" class="form-control" id="nuTar" name="nuTar" required>
    </div>
    <div class="col-md-3 position-relative">
        <label for="feTar" class="form-label"><b>Fecha Vencimiento</b></label>
        <input type="date" class="form-control" id="feTar" name="feTar" required>
    </div>
    <div class="col-md-3 position-relative">
        <label for="cvv" class="form-label"><b>CVV</b></label>
        <input type="password" class="form-control" id="cvv" name="cvv" required>
    </div>
    <div class="col-12">
        <button class="btn btn-light" type="submit">Comprar</button>
    </div>
</form>

      
  </body>
</html>