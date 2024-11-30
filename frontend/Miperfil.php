<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: inicioSesion.html");
    exit;
}

require_once '../src/config/database.php';

$database = new Database();
$conn = $database->getConnection();

$id_cliente = $_SESSION['id_cliente'];
$clienteData = [];
$comprasData = [];

if ($conn) {
    try {
        // Obtener datos del cliente
        $sqlCliente = "SELECT nombre, apellido, direccion, ciudad, estado, correo, telefono 
                       FROM clientes WHERE id_cliente = :id_cliente";
        $stmtCliente = $conn->prepare($sqlCliente);
        $stmtCliente->bindParam(':id_cliente', $id_cliente);
        $stmtCliente->execute();
        $clienteData = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        // Obtener datos de las compras del cliente
        $sqlCompras = "SELECT c.fechacompra, l.nombre AS nombre_libro, l.cantidad, c.nomTar 
                       FROM compras c 
                       JOIN libros l ON c.id_libro = l.id_libro 
                       WHERE c.id_cliente = :id_cliente";
        $stmtCompras = $conn->prepare($sqlCompras);
        $stmtCompras->bindParam(':id_cliente', $id_cliente);
        $stmtCompras->execute();
        $comprasData = $stmtCompras->fetchAll(PDO::FETCH_ASSOC);
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
    <a href="Libros.html">Libros</a>
</div>

<hr style="margin-top: 2%; width: 100%; height: 20px; background-color: rgb(174, 144, 185);">

<div class="col-12">
    <a href="index.html" class="btn btn-light" style="background-color: rgb(149, 109, 150); color: white;">Cerrar Sesión</a>
</div>

<hr style="margin-top: 2%; width: 100%; height: 20px; background-color: rgb(174, 144, 185);">

<div class="card" style="background-color:#D1C4E9">
    <div class="card-header" style="background-color:#B39DDB">Mis datos personales</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-success">
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($clienteData): ?>
                    <tr>
                        <td><?= htmlspecialchars($clienteData['nombre']) ?></td>
                        <td><?= htmlspecialchars($clienteData['apellido']) ?></td>
                        <td><?= htmlspecialchars($clienteData['direccion']) ?></td>
                        <td><?= htmlspecialchars($clienteData['ciudad']) ?></td>
                        <td><?= htmlspecialchars($clienteData['estado']) ?></td>
                        <td><?= htmlspecialchars($clienteData['correo']) ?></td>
                        <td><?= htmlspecialchars($clienteData['telefono']) ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="7">No se encontraron datos del cliente.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<hr style="margin-top: 8%; width: 100%; height: 20px; background-color: rgb(174, 144, 185);">

<div class="card" style="background-color:#D1C4E9">
    <div class="card-header" style="background-color:#B39DDB">Mis compras</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-success">
                <tr>
                    <th>Fecha Compra</th>
                    <th>Nombre Libro</th>
                    <th>Cantidad</th>
                    <th>Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($comprasData): ?>
                    <?php foreach ($comprasData as $compra): ?>
                        <tr>
                            <td><?= htmlspecialchars($compra['fechacompra']) ?></td>
                            <td><?= htmlspecialchars($compra['nombre_libro']) ?></td>
                            <td><?= htmlspecialchars($compra['cantidad']) ?></td>
                            <td><?= htmlspecialchars($compra['nomTar']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No se encontraron compras.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

