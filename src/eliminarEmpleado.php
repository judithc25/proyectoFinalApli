<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No estás autenticado.']);
    exit;
}

require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$id_empleado_sesion = $_SESSION['id_empleado']; // ID del empleado autenticado
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_empleado']) && $data['id_empleado'] == $id_empleado_sesion) {
    try {
        $sql = "DELETE FROM empleados WHERE id_empleado = :id_empleado";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_empleado', $id_empleado_sesion);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Registro eliminado correctamente.']);
            session_destroy(); 
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el registro.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No tienes permiso para realizar esta acción.']);
}
