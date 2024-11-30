<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nombre = $_POST['nombre'];
    $autor = $_POST['autor'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['tipo']; 
    $precio = $_POST['precio'];
    $urlimagen = $_POST['imagen'];
    $cantidad = $_POST['cantidad'];

   
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        try {
            
            $sql = "INSERT INTO libros (name, autor, descripcion, categoria, precio, urlimagen, cantidad) 
                    VALUES (:nombre, :autor, :descripcion, :categoria, :precio, :urlimagen, :cantidad)";
            $stmt = $conn->prepare($sql);

            
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':autor', $autor);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':urlimagen', $urlimagen);
            $stmt->bindParam(':cantidad', $cantidad);

            
            if ($stmt->execute()) {
                header("Location: ../frontend/Inventario.html");
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
