<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController {

    public static function login(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new User($_POST);
            $alertas = $auth->validateLogin();

            if(empty($alertas)){
                $user = User::where('email', $auth->email);

                if($user){
                    if($user->verificateUser($auth->password)){
                        session_start();
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name . " " . $user->apellido;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;
                        if($user->admin === '1'){
                            $_SESSION ['admin'] = $user->admin ?? null;
                            header('location: /admin');
                        } else{
                            header('location: /cita');
                        }
                        // header('location: /');
                    }
                } else{
                    User::setAlerta('error', 'Usuario no encontrado');
                }

            }

        }
        $alertas = User::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
        ]);
    }

    public static function logout() {
        echo "Desde Logout";
    }
    public static function olvide(Router $router) {
        $router->render('auth/olvide', [

        ]);
    }
    public static function recuperar() {
        echo "Desde Recuperar";
    }
    public static function crear(Router $router) {

        $user = new User($_POST);
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sincronizar($_POST);
            
            $alertas = $user->validateNewAcount();
            
            if (empty($alertas)) {
                $resultado = $user->isUserExist();
                if ($resultado > 0) {
                    $alertas['error'][] = 'El email ya está en uso*';
                } else {
                    $user->hashPassword();
                    $user->createToken();

                    // Enviar Email
                    $email = new Email($user->email, $user->name, $user->token);
                    // $email->sendConfirmation();

                    // Crear usuario
                    $resultado = $user->guardar();
                    if($resultado){
                        header('location: /confirmar?token='. $user->token);
                    }


                    // debuguear($user);
                    // $user->guardar();

                }
            }
        }
        

        $router->render('auth/crear-cuenta', [
            'user' => $user,
            'alertas' => $alertas
        ]);
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        
        $token = s($_GET['token']);

        $user = User::where('token', $token);

        if(empty($user)){
            User::setAlerta('error', 'El token no es valido');
        }
        else{
            $user->confirmado = 1;
            $user->token = null;
            $user->guardar();
            User::setAlerta('exito', mensaje: 'Cuenta confirmada y creada');
        }

        $alertas = User::getAlertas();
        $router->render('auth/confirmar', [
            'alertas' => $alertas
        ]);



    }

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje');
    }
}
