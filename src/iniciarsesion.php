<?php
session_start(); 
echo 'Ruta: ' . realpath('config/database.php');
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

   
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            
            $sql = "SELECT * FROM clientes WHERE usuario = :usuario";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuarioData && password_verify($password, $usuarioData['contraseña'])) {
                
                $_SESSION['usuario'] = $usuarioData['usuario'];
                $_SESSION['nombre'] = $usuarioData['nombre'];
                $_SESSION['id_cliente'] = $usuarioData['id_cliente'];

                
                header("Location: ../frontend/Miperfil.php");
                exit;
            } else {
                
                echo "Usuario o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
        }
    } else {
        echo "No se pudo conectar a la base de datos.";
    }
} else {
    echo "Método no permitido.";
}
?>
