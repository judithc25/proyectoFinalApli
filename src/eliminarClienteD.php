<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cliente'])) {
    $id_cliente = intval($_POST['id_cliente']);

    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            $sql = "DELETE FROM clientes WHERE id_cliente = :id_cliente";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: ../frontend/Datos.php");
            exit;
        } catch (PDOException $e) {
            echo "Error al eliminar el cliente: " . $e->getMessage();
        }
    }
}
