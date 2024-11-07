<?php

namespace Controllers;

use MVC\Router;
use Model\Cita;
use Model\AdminCita;

class CitaController {
    public static function index(Router $router) {
        session_start();
        isAuth();
        $router->render('cita/index', [
            'name'=> $_SESSION['name'],
            'id' => $_SESSION['id'],
        ]);
    }
    public static function citas(Router $router) {
        session_start();
        isAuth();

        $consulta = "SELECT citas.id, citas.fecha, citas.hora, citas.hora_fin, CONCAT(users.name, ' ', users.apellido) AS cliente, ";
        $consulta .= "users.email, users.telefono, servicios.nombre AS servicio, servicios.precio, empleados.nombre AS empleado ";
        $consulta .= "FROM citas ";
        $consulta .= "LEFT OUTER JOIN users ON citas.userId = users.id ";
        $consulta .= "LEFT OUTER JOIN citas_servicios ON citas_servicios.citaId = citas.id ";
        $consulta .= "LEFT OUTER JOIN servicios ON servicios.id = citas_servicios.servicioId ";
        $consulta .= "LEFT OUTER JOIN empleados ON citas.empleadoId = empleados.id ";
        $consulta .= "WHERE citas.userId = " . $_SESSION['id'] . " ";
        $consulta .= "AND citas.fecha >= '" . date('Y-m-d') . "';";
        $citas = AdminCita::SQL($consulta);
        

        $router->render('cita/citas', [
            'name'=> $_SESSION['name'],
            'id' => $_SESSION['id'],
            'citas' => $citas,
        ]);
    }
    public static function tcitas(Router $router) {
        session_start();
        isAuth();


        $consulta = "SELECT citas.id, citas.fecha, citas.hora, citas.hora_fin, CONCAT(users.name, ' ', users.apellido) AS cliente, ";
        $consulta .= "users.email, users.telefono, servicios.nombre AS servicio, servicios.precio, empleados.nombre AS empleado ";
        $consulta .= "FROM citas ";
        $consulta .= "LEFT OUTER JOIN users ON citas.userId = users.id ";
        $consulta .= "LEFT OUTER JOIN citas_servicios ON citas_servicios.citaId = citas.id ";
        $consulta .= "LEFT OUTER JOIN servicios ON servicios.id = citas_servicios.servicioId ";
        $consulta .= "LEFT OUTER JOIN empleados ON citas.empleadoId = empleados.id ";
        $consulta .= "WHERE citas.userId = " . $_SESSION['id'] . ";"; 
        $citas = AdminCita::SQL($consulta);
        


        $router->render('cita/tcitas', [
            'name'=> $_SESSION['name'],
            'id' => $_SESSION['id'],
            'citas' => $citas,
        ]);
    }
}