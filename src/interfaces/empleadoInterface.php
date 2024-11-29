<?php
interface IEmpleado {
    public function crearEmpleado($idempleado);
    public function actualizaEmpleado($idempleado);
    public function borrarEmpleado($idempleado);
    public function obtenerEmpleados();
}
?>