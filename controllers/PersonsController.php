<?php 

namespace Controllers;

use Model\Persona;
use MVC\Router;

class PersonsController {
    public static function index(Router $router) {
        session_start();
        isAdmin();
        $personas = Persona::all();

        $router->render('personas/index', [
            'name' => $_SESSION['name'],
            'personas' => $personas,
        ]);
    }
    public static function crear(Router $router) {
        session_start();
        isAdmin();
        $persona = new Persona($_POST);
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $persona->sincronizar($_POST);

            $alertas = $persona->validar();

            if (empty($alertas)) {
                $persona->guardar();
                header('location: /personas');
            }
        }
        $router->render('/personas/crearPersona', [
            'name' => $_SESSION['name'],
            'personas' => $persona,
            'alertas' => $alertas,
        ]);
    }
    public static function eliminar(Router $router) {
        session_start();
        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $persona = Persona::find($id);
            $persona->eliminar();
            header('location: /personas');
        }
    }
}