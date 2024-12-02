<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_empleado'])) {
    $id_empleado = intval($_POST['id_empleado']);

    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            $sql = "DELETE FROM empleados WHERE id_empleado = :id_empleado";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_empleado', $id_empleado, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: ../frontend/Datos.php");
            exit;
        } catch (PDOException $e) {
            echo "Error al eliminar el empleado: " . $e->getMessage();
        }
    }
}
