<?php
interface Iinventario {
    public function crearLibro($inventario);
    public function actualizarLibro($inventario);
    public function borrarLibro($idinventario);
    public function obtenerLibros();
}
?>