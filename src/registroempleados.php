<?php
header('Content-Type: application/json'); // Establece el tipo de respuesta como JSON

require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'] ?? null;
    $apellido = $_POST['apellido'] ?? null;
    $telefono = $_POST['telefono'] ?? null;
    $correo = $_POST['correo'] ?? null;
    $contratacion = $_POST['contratacion'] ?? null;
    $id_puesto = $_POST['puesto'] ?? null; // Capturar el ID del puesto seleccionado
    $usuario = $_POST['usuario'] ?? null;
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Validar que los campos requeridos no estén vacíos
    if (!$nombre || !$apellido || !$telefono || !$correo || !$contratacion || !$id_puesto || !$usuario || !$password) {
        echo json_encode(['status' => 'error', 'message' => 'Por favor, completa todos los campos obligatorios.']);
        exit();
    }

    // Conectar con la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            // Preparar la consulta SQL
            $sql = "INSERT INTO empleados (nombre, apellido, telefono, correo, contratacion, id_puesto, usuario, password) 
                    VALUES (:nombre, :apellido, :telefono, :correo, :contratacion, :id_puesto, :usuario, :password)";
            $stmt = $conn->prepare($sql);

            // Asignar los valores a los parámetros
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contratacion', $contratacion);
            $stmt->bindParam(':id_puesto', $id_puesto);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':password', $password);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Registro exitoso.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Hubo un error al registrar los datos.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo conectar a la base de datos.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}


