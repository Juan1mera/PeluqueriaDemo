<?php

namespace Model;

class AdminCita extends ActiveRecord {
    protected static $tabla = 'citas_servicios';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'hora_fin', 'cliente' ,'email', 'telefono', 'servicio', 'precio', 'empleado'];

    public $id;
    public $fecha;
    public $hora;
    public $hora_fin;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;
    public $empleado;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->hora_fin = $args['hora_fin'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->empleado = $args['empleado'] ?? '';
    }

}