<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No estás autenticado.']);
    exit;
}

require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$id_cliente_sesion = $_SESSION['id_cliente']; 
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_cliente']) && $data['id_cliente'] == $id_cliente_sesion) {
    try {
        $sql = "DELETE FROM clientes WHERE id_cliente = :id_cliente";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente_sesion);
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
