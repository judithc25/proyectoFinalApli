<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/database.php';

// Conectar con la base de datos
$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    try {
        // Consulta para obtener todos los libros
        $sql = "SELECT * FROM libros";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Obtener los resultados como un arreglo asociativo
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Configurar encabezados y devolver el JSON
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($books);
    } catch (PDOException $e) {
        http_response_code(500); // Código de error de servidor
        echo json_encode(["error" => "Error al obtener los libros: " . $e->getMessage()]);
    }
} else {
    http_response_code(500); // Código de error de servidor
    echo json_encode(["error" => "No se pudo conectar a la base de datos."]);
}
?>

