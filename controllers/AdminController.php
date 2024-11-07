<?php
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router){
        session_start();
        
        isAdmin();

        $fecha = $_GET['fecha'] ??  date('Y-m-d');

        $fechas = explode('-', $fecha);

        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('location: /404');
        }


        $consulta = "SELECT citas.id, citas.hora, citas.hora_fin, CONCAT(users.name, ' ', users.apellido) AS cliente, ";
        $consulta .= "users.email, users.telefono, servicios.nombre AS servicio, servicios.precio, empleados.nombre AS empleado ";
        $consulta .= "FROM citas ";
        $consulta .= "LEFT OUTER JOIN users ON citas.userId = users.id ";
        $consulta .= "LEFT OUTER JOIN citas_servicios ON citas_servicios.citaId = citas.id ";
        $consulta .= "LEFT OUTER JOIN servicios ON servicios.id = citas_servicios.servicioId ";
        $consulta .= "LEFT OUTER JOIN empleados ON citas.empleadoId = empleados.id ";
        $consulta .= "WHERE citas.fecha = '$fecha';"; 
        $citas =AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'citas' => $citas,
            'fecha' => $fecha,
        ]);
    }
}