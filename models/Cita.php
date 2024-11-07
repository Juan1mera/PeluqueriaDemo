<?php

namespace Model;

class Cita extends ActiveRecord{
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'userId', 'hora_fin', 'empleadoId'];

    public $id;
    public $fecha;
    public $hora;
    public $userId;
    public $hora_fin;
    public $empleadoId;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->userId = $args['userId'] ?? '';
        $this->hora_fin = $args['hora_fin'] ?? '';
        $this->empleadoId = $args['empleadoId'] ?? '';
    }
}