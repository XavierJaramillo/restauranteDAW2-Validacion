<?php
class Reserva { 
    //ATRIBUTOS
    private $id_reserva;
    private $dia;
    private $franja;
    private $id_mesa;
    private $nombre_comensal;
    private $num_comensales;
    private $id_camarero;

    //CONSTRUCTOR 
    function __construct() {
    }

    //GETTERS AND SETTERS
    public function getId_reserva() {
        return $this->id_reserva;
    } 
    public function getDia() {
        return $this->dia;
    }
    public function getFranja() {
        return $this->franja;
    }
    public function getId_mesa() {
        return $this->id_mesa;
    }
    public function getNombre_comensal() {
        return $this->nombre_comensal;
    }
    public function getNum_comensales() {
        return $this->num_comensales;
    }
    public function getId_camarero() {
        return $this->id_camarero;
    }

    public function setId_reserva($id_reserva) {
        $this->id_reserva = $id_reserva;
    }
    public function setDia($dia) {
        $this->dia = $dia;
    }
    public function setFranja($franja) {
        $this->franja = $franja;
    }
    public function setId_mesa($id_mesa) {
        $this->id_mesa = $id_mesa;
    }
    public function setNombre_comensal($nombre_comensal) {
        $this->nombre_comensal = $nombre_comensal;
    }
    public function setNum_comensales($num_comensales) {
        $this->num_comensales = $num_comensales;
    }
    public function setId_camarero($id_camarero) {
        $this->id_camarero = $id_camarero;
    }
}