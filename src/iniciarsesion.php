<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            $sqlClientes = "SELECT * FROM clientes WHERE usuario = :usuario";
            $stmtClientes = $conn->prepare($sqlClientes);
            $stmtClientes->bindParam(':usuario', $usuario);
            $stmtClientes->execute();
            $clienteData = $stmtClientes->fetch(PDO::FETCH_ASSOC);

            if ($clienteData && password_verify($password, $clienteData['contraseña'])) {
              
                $_SESSION['usuario'] = $clienteData['usuario'];
                $_SESSION['nombre'] = $clienteData['nombre'];
                $_SESSION['id_cliente'] = $clienteData['id_cliente'];

                header("Location: ../frontend/Miperfil.php");
                exit;
            }

           
            $sqlEmpleados = "SELECT * FROM empleados WHERE usuario = :usuario";
            $stmtEmpleados = $conn->prepare($sqlEmpleados);
            $stmtEmpleados->bindParam(':usuario', $usuario);
            $stmtEmpleados->execute();
            $empleadoData = $stmtEmpleados->fetch(PDO::FETCH_ASSOC);

            if ($empleadoData && password_verify($password, $empleadoData['password'])) {
                
                $_SESSION['usuario'] = $empleadoData['usuario'];
                $_SESSION['nombre'] = $empleadoData['nombre'];
                $_SESSION['id_empleado'] = $empleadoData['id_empleado'];

                header("Location: ../frontend/MiperfilEm.php");
                exit;
            }

           
            echo "Usuario o contraseña incorrectos.";
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
