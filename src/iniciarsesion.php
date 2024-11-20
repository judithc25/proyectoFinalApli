<?php
session_start(); // Iniciar sesión para almacenar información del usuario

echo 'Ruta: ' . realpath('config/database.php');
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['contraseña'];

    // Conectar a la base de datos
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            // Consulta para obtener el usuario
            $sql = "SELECT * FROM Clientes WHERE usuario = :usuario";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuarioData && password_verify($password, $usuarioData['password'])) {
                // Credenciales válidas, guardar información en la sesión
                $_SESSION['usuario'] = $usuarioData['usuario'];
                $_SESSION['nombre'] = $usuarioData['nombre'];
                $_SESSION['id_cliente'] = $usuarioData['id_cliente'];

                // Redirigir al perfil del usuario
                header("Location: Miperfil.php");
                exit;
            } else {
                // Credenciales inválidas
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
