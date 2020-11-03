<?php
class Espacio {
    //ATRIBUTOS
    private $id_espacio;
    private $tipo_espacio;
    private $capacidad_mesas;

    //CONSTRUCTOR 
    function __construct($tipo_espacio, $capacidad_mesas) {
        $this->tipo_espacio=$tipo_espacio;
        $this->capacidad_mesas=$capacidad_mesas;
    }

    //GETTERS & SETTERS
    public function getId_espacio() {
        return $this->id_espacio;
    }
    public function getTipo_espacio() {
        return $this->tipo_espacio;
    }
    public function getCapacidad_mesas() {
        return $this->capacidad_mesas;
    }

    public function setId_espacio($id_espacio) {
        $this->id_espacio = $id_espacio;
    }
    public function setTipo_espacio($tipo_espacio) {
        $this->tipo_espacio = $tipo_espacio;
    }
    public function setCapacidad_mesas($capacidad_mesas) {
        $this->capacidad_mesas = $capacidad_mesas;
    }
}

?>