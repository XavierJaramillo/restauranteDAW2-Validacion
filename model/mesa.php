<?php
//MartinezFalconi

//JaramilloVives
class Mesa {
    //ATRIBUTOS
    private $id_mesa;
    private $capacidad_mesa;
    private $capacidad_max;
    private $disp_mesa;
    private $id_camarero;
    private $id_espacio;

    //CONSTRUCTOR 
    function __construct($capacidad_mesa, $capacidad_max, $disp_mesa, $id_camarero, $id_espacio) {
        $this->capacidad_mesa=$capacidad_mesa;
        $this->capacidad_max=$capacidad_max;
        $this->disp_mesa=$disp_mesa;
        $this->id_camarero=$id_camarero;
        $this->id_espacio=$id_espacio;
    }

    //GETTERS & SETTERS
    public function getId_mesa() {
        return $this->id_mesa;
    } 
    public function getCapacidad_mesa() {
        return $this->capacidad_mesa;
    }
    public function getCapacidad_max() {
        return $this->capacidad_max;
    }
    public function getDisp_mesa() {
        return $this->disp_mesa;
    }
    public function getId_camarero() {
        return $this->id_camarero;
    }
    public function getId_espacio() {
        return $this->id_espacio;
    }
    
    public function setId_mesa($id_mesa) {
        $this->id_mesa = $id_mesa;
    }
    public function setCapacidad_mesa($capacidad_mesa) {
        $this->capacidad_mesa = $capacidad_mesa;
    }
    public function setCapacidad_max($capacidad_max) {
        $this->capacidad_max = $capacidad_max;
    }
    public function setDisp_mesa($disp_mesa) {
        $this->disp_mesa = $disp_mesa;
    }
    public function setId_camarero($id_camarero) {
        $this->id_camarero = $id_camarero;
    }
    public function setId_espacio($id_espacio) {
        $this->id_espacio = $id_espacio;
    }
}
//FernandezVives

?>