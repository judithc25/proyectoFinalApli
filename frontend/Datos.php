<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: inicioSesion.html");
    exit;
}

require_once '../src/config/database.php';

$database = new Database();
$conn = $database->getConnection();

$compras = [];
$empleados = [];
$clientes = [];

if ($conn) {
    try {
        $sqlCompras = "
            SELECT c.id_compra, c.fechacompra, c.id_libro, c.id_cliente, cl.usuario
            FROM compras c
            LEFT JOIN clientes cl ON c.id_cliente = cl.id_cliente";
        $stmtCompras = $conn->query($sqlCompras);
        $compras = $stmtCompras->fetchAll(PDO::FETCH_ASSOC);

        $sqlEmpleados = "
            SELECT e.id_empleado, e.nombre, e.usuario, e.contratacion, e.telefono, p.titulo
            FROM empleados e
            LEFT JOIN puestos p ON e.id_puesto = p.id_puesto";
        $stmtEmpleados = $conn->query($sqlEmpleados);
        $empleados = $stmtEmpleados->fetchAll(PDO::FETCH_ASSOC);

        
        $sqlClientes = "
            SELECT id_cliente, nombre, apellido, usuario, telefono, correo, ciudad
            FROM clientes";
        $stmtClientes = $conn->query($sqlClientes);
        $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="shortcut icon" href="./imagenes/favicon.png" type="image/x-icon">
</head>
<body>
<div class="navbar">
    <img src="./imagenes/librosapi.png" alt="libros">
    <h1><b>Libby</b></h1>
    <a href="Inventario.html">Inventario</a>
    <a href="MiperfilEm.php">Mi Perfil</a>
</div>

<hr style="margin-top: 1%; width: 100%; height: 20px; background-color: rgb(174, 144, 185);">

<div class="card" style="background-color:#D1C4E9">
    <div class="card-header" style="background-color:#B39DDB">Compras</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-success">
                <tr>
                    <th style="background-color:#B39DDB">Id</th>
                    <th style="background-color:#B39DDB">Fecha Compra</th>
                    <th style="background-color:#B39DDB">Id Libro</th>
                    <th style="background-color:#B39DDB">Id Cliente</th>
                    <th style="background-color:#B39DDB">Usuario</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($compras as $compras): ?>
                <tr>
                    <td><?= htmlspecialchars($compras['id_compra']) ?></td>
                    <td><?= htmlspecialchars($compras['fechacompra']) ?></td>
                    <td><?= htmlspecialchars($compras['id_libro']) ?></td>
                    <td><?= htmlspecialchars($compras['id_cliente']) ?></td>
                    <td><?= htmlspecialchars($compras['usuario']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<hr style="margin-top: 3%; width: 100%; height: 20px; background-color: rgb(174, 144, 185);">


<div class="card" style="background-color:#D1C4E9">
    <div class="card-header" style="background-color:#B39DDB">Empleados</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-success">
                <tr>
                    <th style="background-color:#B39DDB">Id</th>
                    <th style="background-color:#B39DDB">Nombre</th>
                    <th style="background-color:#B39DDB">Usuario</th>
                    <th style="background-color:#B39DDB">Fecha Contratación</th>
                    <th style="background-color:#B39DDB">Teléfono</th>
                    <th style="background-color:#B39DDB">Nombre de Puesto</th>
                    <th style="background-color:#B39DDB">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $empleado): ?>
                    <tr>
                        <td><?= htmlspecialchars($empleado['id_empleado']) ?></td>
                        <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                        <td><?= htmlspecialchars($empleado['usuario']) ?></td>
                        <td><?= htmlspecialchars($empleado['contratacion']) ?></td>
                        <td><?= htmlspecialchars($empleado['telefono']) ?></td>
                        <td><?= htmlspecialchars($empleado['titulo'] ?? 'N/A') ?></td>
                        <td>
                        <form action="../src/eliminarEmpleadoD.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_empleado" value="<?= $empleado['id_empleado'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                         </form>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<hr style="margin-top: 3%; width: 100%; height: 20px; background-color: rgb(174, 144, 185);">


<div class="card" style="background-color:#D1C4E9">
    <div class="card-header" style="background-color:#B39DDB">Clientes</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-success">
                <tr>
                    <th style="background-color:#B39DDB">Id</th>
                    <th style="background-color:#B39DDB">Nombre</th>
                    <th style="background-color:#B39DDB">Apellido</th>
                    <th style="background-color:#B39DDB">Usuario</th>
                    <th style="background-color:#B39DDB">Teléfono</th>
                    <th style="background-color:#B39DDB">Correo</th>
                    <th style="background-color:#B39DDB">Ciudad</th>
                    <th style="background-color:#B39DDB">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= htmlspecialchars($cliente['id_cliente']) ?></td>
                        <td><?= htmlspecialchars($cliente['nombre']) ?></td>
                        <td><?= htmlspecialchars($cliente['apellido']) ?></td>
                        <td><?= htmlspecialchars($cliente['usuario']) ?></td>
                        <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                        <td><?= htmlspecialchars($cliente['correo']) ?></td>
                        <td><?= htmlspecialchars($cliente['ciudad']) ?></td>
                        <td>
                        <form action="../src/eliminarClienteD.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
