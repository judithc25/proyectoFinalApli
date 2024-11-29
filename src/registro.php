<?php
require_once 'config/database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $estado = $_POST['estado'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

     // Validar que los campos requeridos no estén vacíos
     if (!$nombre || !$apellido || !$usuario || !$telefono || !$correo || !$direccion || !$ciudad || !$estado || !$password) {
        echo json_encode(['status' => 'error', 'message' => 'Por favor, completa todos los campos obligatorios.']);
        exit();
    }
    
    // Conectar con la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            // Preparar la consulta SQL
            $sql = "INSERT INTO clientes (nombre, apellido, usuario, telefono, correo, direccion, ciudad, estado, contraseña) 
                    VALUES (:nombre, :apellido, :usuario, :telefono, :correo, :direccion, :ciudad, :estado, :password)";
            $stmt = $conn->prepare($sql);

            // Asignar los valores a los parámetros
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':estado', $estado);
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
?>

