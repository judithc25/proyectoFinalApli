<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/interfaces/inventarioInterface.php';

class librosRepository implements Iinventario
{
    private $conn;
    public function_construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function crearLibro($inventario) {
        $sql = "INSERT INTO inventario (id, nombre, descripcion, categoria, cantidad, autor, precio ) VALUES (:nombre, :descripcion, :tipo, :precio, :imagen)";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':id', $producto->id);
        $resultado->bindParam(':nombre', $producto->nombre);
        $resultado->bindParam(':descripcion', $producto->descripcion);
        $resultado->bindParam(':categoria', $producto->categoria);
        $resultado->bindParam(':cantidad', $producto->cantidad);
        $resultado->bindParam(':autor', $producto->autor);
        $resultado->bindParam(':precio', $producto->precio);

        if($resultado->execute()){
            return ['mensaje' => 'Libro Creado'];
        }
        return ['mensaje' => 'Error al crear producto'];
    }

    public function actualizarLibro($inventario) {
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, tipo = :tipo, precio = :precio, imagen = :imagen WHERE idproducto = :idproducto";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto', $producto->idproducto);
        $resultado->bindParam(':nombre', $producto->nombre);
        $resultado->bindParam(':descripcion', $producto->descripcion);
        $resultado->bindParam(':tipo', $producto->tipo);
        $resultado->bindParam(':precio', $producto->precio);
        $resultado->bindParam(':imagen', $producto->imagen);

        if($resultado->execute()){
            return ['mensaje' => 'Producto Actualizado'];
        }
        return ['mensaje' => 'Error al actualizar producto'];
    }

    public function borrarLibro($inventario) {
        $sql = "DELETE FROM productos WHERE idproducto = :idproducto";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto', $idproducto);

        if($resultado->execute()){
            return ['mensaje' => 'Producto Borrado'];
        }
        return ['mensaje' => 'Error al borrar producto'];
    }

    public function obtenerProductos|($producto) {
        $sql = "SELECT * FROM productos";
        $resultado = $this->conn->prepare($sql);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorNombre($nombre) {
        $sql = "SELECT * FROM nombre = :nombre";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':nombre', $nombre);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }
    public function obtenerProductoPorId($idproducto) {
        $sql = "SELECT * FROM productos WHERE idproducto = :idproducto";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto', $idproducto);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }
}


?>