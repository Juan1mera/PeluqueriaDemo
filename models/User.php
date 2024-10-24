<?php

namespace Model;

class User extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'users';
    protected static $columnasDB = ["id", "name", "apellido", "email", "password", "telefono", "admin", "confirmado", "token"];

    public $id;
    public $name;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de validacion
    public function validateNewAcount() {
        if(!$this->name) {
            self::$alertas['error'][] = 'El nombre es requerido*';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es requerido*';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es requerido*';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono es requerido*';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es requerida*';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres*';
        }

        return self::$alertas;
    }

    public function validateLogin() {
        if(!$this->email){
            self::$alertas['error'][] = "El email es requerido*";
        }
        if(!$this->password){
            self::$alertas['error'][] = "La contraseña es requerida*";
        }
        return self::$alertas;
    }

    public function isUserExist() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        
        return $resultado->num_rows;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken() {
        $this->token = uniqid();
    }

    public function verificateUser($password) {
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'La contraseña es incorrecta o la cuenta no ha sido confirmada';
        } else{
            return true;
        }
        // debuguear($resultado);
    }

}
