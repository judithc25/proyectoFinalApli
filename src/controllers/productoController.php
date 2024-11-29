<?php
require_once BASE_PATH . '/repositories/productoRepository.php';
require_once BASE_PATH . '/models/productoModel.php';


class ProductoController {
    private $productoRepository;

    public function __construct () {
        $this->productoRepository = new ProductoRepository();
    }

    public function crearProducto($data) {
        $producto = new Producto();
        $producto->nombre = $data['nombre'];
        $producto->nombre = $data['descripcion'];
        $producto->nombre = $data['tipo'];
        $producto->nombre = $data['precio'];
        $producto->nombre = $data['imagen'];
        return
        $this->productoRepository->crearProducto($producto);
    }

    public function actualizarProducto($data) {
        $producto = new Producto();
        $producto->idproducto = $data['idproducto'];
        $producto->nombre = $data['nombre'];
        $producto->nombre = $data['descripcion'];
        $producto->nombre = $data['tipo'];
        $producto->nombre = $data['precio'];
        $producto->nombre = $data['imagen'];
        return
        $this->productoRepository->actualizarProducto($producto);
    }

    public function borrarProducto($idproducto){
        return
        $this->productoRepository->borrarProducto($idproducto);
    }

    public function obtenerProductos(){
        return
        $this->productoRepository->obtenerProductos();
    }
    public function obtenerProductosPorNombre($nombre){
        return
        $this->productoRepository->obtenerProductosPorNombre($nombre);
    }
    public function obtenerProductoPorId($id){
        return
        $this->productoRepository->obtenerProductoPorId($id['id']);
    }


}


?>