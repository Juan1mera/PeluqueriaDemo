<?php

namespace Model;

class Cita extends ActiveRecord{
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'userId'];

    public $id;
    public $fecha;
    public $hora;
    public $userId;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->userId = $args['userId'] ?? '';
    }
}