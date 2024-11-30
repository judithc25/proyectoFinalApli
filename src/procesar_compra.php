<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $usuario = $_POST['usuario'];
    $fecha = $_POST['fecha'];
    $cantidad = intval($_POST['cantidad']);
    $id_libro = intval($_POST['libro']);
    $nombreTar = $_POST['nombre'];
    $numTar = $_POST['nuTar'];
    $fechaTar = $_POST['feTar'];
    $cvv = $_POST['cvv'];

    
    $database = new Database();
    $conn = $database->getConnection();

    try {
        
        $query = "SELECT id_cliente FROM clientes WHERE usuario = :usuario";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "Usuario no encontrado.";
            exit;
        }

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_cliente = $cliente['id_cliente'];

       
        $query = "SELECT cantidad FROM libros WHERE id_libro = :id_libro";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_libro', $id_libro, PDO::PARAM_INT);
        $stmt->execute();

        $libro = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$libro || $libro['cantidad'] < $cantidad) {
            echo "Stock insuficiente del libro seleccionado.";
            exit;
        }

        
        $query = "INSERT INTO compras (id_libro, id_cliente, fechacompra, nomTar, numTar, fechaTar, cvv) 
                  VALUES (:id_libro, :id_cliente, :fechacompra, :nomTar, :numTar, :fechaTar, :cvv)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_libro', $id_libro, PDO::PARAM_INT);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':fechacompra', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':nomTar', $nombreTar, PDO::PARAM_STR);
        $stmt->bindParam(':numTar', $numTar, PDO::PARAM_STR);
        $stmt->bindParam(':fechaTar', $fechaTar, PDO::PARAM_STR);
        $stmt->bindParam(':cvv', $cvv, PDO::PARAM_STR);
        $stmt->execute();

        
        $query = "UPDATE libros SET cantidad = cantidad - :cantidad WHERE id_libro = :id_libro";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindParam(':id_libro', $id_libro, PDO::PARAM_INT);
        $stmt->execute();

        
        header("Location: ../frontend/Miperfil.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
