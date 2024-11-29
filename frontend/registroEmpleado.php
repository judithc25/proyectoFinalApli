<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/registro.css">
    <link rel="shortcut icon" href="./imagenes/favicon.png" type="image/x-icon">
  </head>
  <body>
    <div class="navbar">
        <img src="./imagenes/librosapi.png" alt="libros">
        <h1><b>Libby</b></h1>
        <a href="index.html">Inicio</a>
        <a href="Libros.html">Libros</a>
    </div>

    <!-- Alerta dinámica -->
    <div id="alert" class="alert d-none" role="alert"></div>

    <!-- Formulario -->
    <form id="registrationForm" class="row g-3 needs-validation">
        <div class="col-md-4 position-relative">
            <label for="nombre" class="form-label"><b>Nombre</b></label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="col-md-4 position-relative">
            <label for="apellido" class="form-label"><b>Apellido</b></label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="col-md-3 position-relative">
            <label for="telefono" class="form-label"><b>Número de Teléfono</b></label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="col-md-3 position-relative">
            <label for="correo" class="form-label"><b>Correo</b></label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="col-md-3 position-relative">
            <label for="contratacion" class="form-label"><b>Fecha contratacion</b></label>
            <input type="date" class="form-control" id="contratacion" name="contratacion" required>
        </div>
        <div class="col-md-3 position-relative">
            <label for="puesto" class="form-label"><b>Puesto</b></label>
            <select class="form-control" id="puesto" name="puesto" required>
                <option value="" disabled selected>Seleccione un puesto</option>
                <?php
                require_once '../src/config/database.php';
                $database = new Database();
                $conn = $database->getConnection();
                if ($conn) {
                    $query = "SELECT id_puesto, titulo FROM puestos";
                    $result = $conn->query($query);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row['id_puesto'] . '">' . $row['titulo'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>    
        <div class="col-md-4 position-relative">
            <label for="usuario" class="form-label"><b>Usuario</b></label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>
        <div class="col-md-3 position-relative">
            <label for="password" class="form-label"><b>Contraseña</b></label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="col-12">
            <button class="btn btn-light" type="submit">Registrarse</button>
        </div>
        <a href="InicioSesion.html">Iniciar sesion</a>
    </form>
    

    <!-- JavaScript -->
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Evita el envío tradicional del formulario

            const formData = new FormData(this); // Captura los datos del formulario

            fetch('../src/registroempleados.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Convierte la respuesta a JSON
            .then(data => {
                const alertDiv = document.getElementById('alert');
                alertDiv.className = `alert alert-${data.status === 'success' ? 'success' : 'danger'}`;
                alertDiv.textContent = data.message;
                alertDiv.classList.remove('d-none'); // Muestra el mensaje
            })
            .catch(error => {
                const alertDiv = document.getElementById('alert');
                alertDiv.className = 'alert alert-danger';
                alertDiv.textContent = 'Hubo un error inesperado.';
                alertDiv.classList.remove('d-none');
                console.error(error);
            });
        });
    </script>
  </body>
</html>
