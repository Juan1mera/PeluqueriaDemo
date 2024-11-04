<?php

namespace Model;

use Model\ActiveRecord;

class Servicio extends ActiveRecord{
    protected static $tabla = 'servicios';

    protected static $columnasDB = ['id', 'nombre', 'precio', 'duracion'];

    public $id;
    public $nombre;
    public $precio;
    public $duracion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->duracion = $args['duracion'] ?? '';
    }

    public function validar() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es requerido*';
        }
        if (!$this->precio) {
            self::$alertas['error'][] = 'El precio es requerido*';
        }
        if (!is_numeric($this->precio)) {
            self::$alertas['error'][] = 'El precio es requerido*';
        }
        if (!$this->duracion) {
            self::$alertas['error'][] = 'La duracion es requerida*';
        }
        return self::$alertas;
    }
}