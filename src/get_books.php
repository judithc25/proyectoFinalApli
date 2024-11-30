<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    try {
       
        $sql = "SELECT * FROM libros";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($books);
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(["error" => "Error al obtener los libros: " . $e->getMessage()]);
    }
} else {
    http_response_code(500); 
    echo json_encode(["error" => "No se pudo conectar a la base de datos."]);
}
?>

