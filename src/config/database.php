<?php
class Database {
    private $host = 'localhost:8889'; 
    private $db_name = 'bibliotecavirtual5'; 
    private $username = 'root'; 
    private $password = 'root'; 
    private $conn;

    
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage(); 
        }

        return $this->conn;
    }
}


$db = new Database();
$conn = $db->getConnection();

?>


