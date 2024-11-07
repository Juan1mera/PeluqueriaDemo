<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\ApiController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\AdminController;
use Controllers\ServicioController;
use MVC\Router;
$router = new Router();


// Iniciar sesion
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

// Recuperar contraseña
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

// Crear cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

$router->get('/confirmar', [LoginController::class, 'confirmar']); 
$router->get('/mensaje', [LoginController::class, 'mensaje']); 


// Area Privada
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/cita/citas', [CitaController::class, 'citas']);
$router->get('/cita/tcitas', [CitaController::class, 'tcitas']);
$router->get('/admin', [AdminController::class, 'index']);

// API citas
$router->get('/api/servicios', [ApiController::class, 'index']);
$router->get('/api/citas', [ApiController::class, 'citas']);
$router->get('/api/empleados', [ApiController::class, 'empleados']);
$router->post('/api/citas', [ApiController::class, 'guardar']);
$router->post('/api/eliminar', [ApiController::class, 'eliminar']);

// CRUD Servicios
$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();