<?php

namespace Controllers;

use MVC\Router;
use Model\Cita;

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

        $citas = Cita::allwhere('userId', $_SESSION['id']);

        $router->render('cita/citas', [
            'name'=> $_SESSION['name'],
            'id' => $_SESSION['id'],
            'citas' => $citas,
        ]);
    }
}