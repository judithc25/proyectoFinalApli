<?php
interface IEmpleado {
    public function crearEmpleado($empleado);
    public function actualizaEmpleado($empleado);
    public function borrarEmpleado($idempleado);
    public function obtenerEmpleados();
}
?>