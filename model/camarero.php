<?php
class Camarero {
    //ATRIBUTOS
    private $id_camarero;
    private $nombre_camarero;
    private $pass_camarero;
    private $rol;
    private $estado;

    //CONSTRUCTOR 
    function __construct($nombre_camarero, $pass_camarero) {
        $this->nombre_camarero=$nombre_camarero;
        $this->pass_camarero=$pass_camarero;
    }

    //GETTERS & SETTERS
    public function getId_camarero() {
        return $this->id_camarero;
    }
    public function getNombre_camarero() {
        return $this->nombre_camarero;
    }
    public function getPass_camarero() {
        return $this->pass_camarero;
    }
    public function getRol() {
        return $this->rol;
    }
    public function getEstado() {
        return $this->estado;
    }

    public function setId_camarero($id_camarero) {
        $this->id_camarero = $id_camarero;
    }
    public function setNombre_camarero($nombre_camarero) {
        $this->nombre_camarero = $nombre_camarero;
    }
    public function setPass_camarero($pass_camarero) {
        $this->pass_camarero = $pass_camarero;
    }
    public function setRol($rol) {
        $this->rol = $rol;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }
}

?>