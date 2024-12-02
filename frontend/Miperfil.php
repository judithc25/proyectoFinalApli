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
      
        $sqlCliente = "SELECT id_cliente, nombre, apellido, usuario, direccion, ciudad, estado, correo, telefono 
                       FROM clientes WHERE id_cliente = :id_cliente";
        $stmtCliente = $conn->prepare($sqlCliente);
        $stmtCliente->bindParam(':id_cliente', $id_cliente);
        $stmtCliente->execute();
        $clienteData = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        
        $sqlCompras = "SELECT c.fechacompra, l.name AS name, c.numTar 
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="shortcut icon" href="./imagenes/favicon.png" type="image/x-icon">
</head>
<body>
<div class="navbar">
    <img src="./imagenes/librosapi.png" alt="libros">
    <h1><b>Libby</b></h1>
    <a href="Libros.html">Libros</a>
</div>
<hr style="margin-top: 1%; width: 100%; height: 20px; background-color: rgb(174, 144, 185);">
<a href="index.html" class="btn btn-light">Cerrar Sesion</a>
<br>
<br>
<hr style="margin-top: 2%; width: 100%; height: 20px; background-color: rgb(174, 144, 185);">


<div class="card" style="background-color:#D1C4E9">
    <div class="card-header" style="background-color:#B39DDB">Mis datos personales</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-success">
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Usuario</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($clienteData): ?>
                    <tr>
                        <td><?= htmlspecialchars($clienteData['nombre']) ?></td>
                        <td><?= htmlspecialchars($clienteData['apellido']) ?></td>
                        <td><?= htmlspecialchars($clienteData['usuario']) ?></td>
                        <td><?= htmlspecialchars($clienteData['direccion']) ?></td>
                        <td><?= htmlspecialchars($clienteData['ciudad']) ?></td>
                        <td><?= htmlspecialchars($clienteData['estado']) ?></td>
                        <td><?= htmlspecialchars($clienteData['correo']) ?></td>
                        <td><?= htmlspecialchars($clienteData['telefono']) ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm eliminar" data-id="<?= $empleadoData['id_empleado'] ?>">Eliminar</button>
                            <button class="btn btn-primary btn-sm actualizar" data-id="<?= $empleadoData['id_empleado'] ?>" data-bs-toggle="modal" data-bs-target="#modalActualizar">Actualizar</button>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="7">No se encontraron datos del cliente.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalActualizar" tabindex="-1" aria-labelledby="modalActualizarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formActualizar">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalActualizarLabel">Actualizar Mis Datos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idEmpleado" name="id_empleado" value="<?= $empleadoData['id_cliente'] ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($empleadoData['nombre']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($empleadoData['apellido']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($empleadoData['telefono']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($empleadoData['correo']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" value="<?= htmlspecialchars($empleadoData['usuario']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($empleadoData['direccion']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?= htmlspecialchars($empleadoData['ciudad']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado" value="<?= htmlspecialchars($empleadoData['estado']) ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
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
                    <th>Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($comprasData): ?>
                    <?php foreach ($comprasData as $compra): ?>
                        <tr>
                            <td><?= htmlspecialchars($compra['fechacompra']) ?></td>
                            <td><?= htmlspecialchars($compra['name']) ?></td>
                            <td><?= htmlspecialchars($compra['numTar']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No se encontraron compras.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="./js/Miperfil.js"></script>
</body>
</html>

