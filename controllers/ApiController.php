<?php
namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;
use Model\Empleados;

class ApiController{
    public static function index(){
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }

    public static function citas(){
        $citas = Cita::all();

        echo json_encode($citas);
    }

    public static function empleados(){
        $empleados = Empleados::all();

        echo json_encode($empleados);
    }

    public static function guardar(){
        
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        $idServicios = explode(',', $_POST['servicios']);

        foreach ($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio,
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }


        echo json_encode(['resultado' => $idServicios]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $cita->eliminar();
            header('location:' .  $_SERVER['HTTP_REFERER']);
        }
    }
}