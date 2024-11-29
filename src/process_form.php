<?php
echo 'Ruta: ' . realpath('config/database.php');
require_once 'config/database.php'; // Ajusta la ruta si es necesario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $autor = $_POST['autor'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['tipo']; // Cambiado para coincidir con el campo del formulario
    $precio = $_POST['precio'];
    $urlimagen = $_POST['imagen'];

    // Crear una instancia de la conexión
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            // Preparar la consulta SQL
            $sql = "INSERT INTO libros (name, autor, descripcion, categoria, precio, urlimagen) 
                    VALUES (:nombre, :autor, :descripcion, :categoria, :precio, :urlimagen)";
            $stmt = $conn->prepare($sql);

            // Asignar los valores a los parámetros
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':autor', $autor);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':urlimagen', $urlimagen);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Libro registrado exitosamente.";
            } else {
                echo "Hubo un error al registrar los datos.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "No se pudo conectar a la base de datos.";
    }
}
?>
