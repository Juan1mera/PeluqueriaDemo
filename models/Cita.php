<?php

namespace Model;

class Cita extends ActiveRecord{
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'userId', 'hora_fin'];

    public $id;
    public $fecha;
    public $hora;
    public $userId;
    public $hora_fin;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->userId = $args['userId'] ?? '';
        $this->hora_fin = $args['hora_fin'] ?? '';
    }
}