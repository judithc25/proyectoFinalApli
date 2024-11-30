<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: inicioSesion.html");
    exit;
}

require_once '../src/config/database.php';

$usuario = $_SESSION['usuario'];

$database = new Database();
$conn = $database->getConnection();

$empleado = [];

if ($conn) {
    try {
        // Consultar datos del empleado según el usuario en sesión
        $sqlEmpleado = "SELECT nombre, apellido, correo, telefono, usuario, contratacion 
                        FROM empleados WHERE usuario = :usuario";
        $stmtEmpleado = $conn->prepare($sqlEmpleado);
        $stmtEmpleado->bindParam(':usuario', $usuario);
        $stmtEmpleado->execute();
        $empleado = $stmtEmpleado->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los datos: " . $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="shortcut icon" href="./imagenes/favicon.png" type="image/x-icon">
</head>
<body>
<div class="navbar">
    <img src="./imagenes/librosapi.png" alt="libros">
    <h1><b>Libby</b></h1>
    <a href="Inventario.html">Inventario</a>
    <a href="Libros.html">Libros</a>
    <a href="Datos.php">Datos</a>
</div>

<hr style="margin-top: 2%; width: 100%; height: 20px; background-color: rgb(174, 144, 185);">

<div class="card" style="background-color:#D1C4E9">
    <div class="card-header" style="background-color:#B39DDB">Mis datos personales</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-success">
                <tr>
                    <th style="background-color:#B39DDB">Nombre</th>
                    <th style="background-color:#B39DDB">Apellido</th>
                    <th style="background-color:#B39DDB">Correo</th>
                    <th style="background-color:#B39DDB">Teléfono</th>
                    <th style="background-color:#B39DDB">Usuario</th>
                    <th style="background-color:#B39DDB">Fecha de Contratación</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($empleado): ?>
                    <tr>
                        <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                        <td><?= htmlspecialchars($empleado['apellido']) ?></td>
                        <td><?= htmlspecialchars($empleado['correo']) ?></td>
                        <td><?= htmlspecialchars($empleado['telefono']) ?></td>
                        <td><?= htmlspecialchars($empleado['usuario']) ?></td>
                        <td><?= htmlspecialchars($empleado['contratacion']) ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No se encontraron datos para este usuario.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
