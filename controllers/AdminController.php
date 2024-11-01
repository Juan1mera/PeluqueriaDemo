<?php
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router){
        session_start();
        $fecha = date('Y-m-d');

        $consulta = "SELECT citas.id, citas.hora, CONCAT( users.name, ' ', users.apellido) as cliente, ";
        $consulta .= " users.email, users.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN users ";
        $consulta .= " ON citas.userId=users.id  ";
        $consulta .= " LEFT OUTER JOIN citas_servicios ";
        $consulta .= " ON citas_servicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_servicios.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";
        $citas =AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'citas' => $citas,
            'fecha' => $fecha,
        ]);
    }
}