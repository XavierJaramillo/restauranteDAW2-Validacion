<?php
//MartinezFalconi

//JaramilloVives
class Horario {
    //ATRIBUTOS
    private $id_horario;
    private $hora_entrada;
    private $hora_salida;
    private $id_mesa;

    //CONSTRUCTOR 
    function __construct($hora_entrada, $hora_salida, $id_mesa) {
        $this->hora_entrada=$hora_entrada;
        $this->hora_salida=$hora_salida;
        $this->id_mesa=$id_mesa;
    }

    //GETTERS & SETTERS
    public function getId_horario() {
        return $this->id_horario;
    }
    public function getHora_entrada() {
        return $this->hora_entrada;
    }
    public function getHora_salida() {
        return $this->hora_salida;
    }
    public function getId_mesa() {
        return $this->id_mesa;
    }
    
    public function setId_horario($id_horario) {
        $this->id_horario = $id_horario;
    }
    public function setHora_entrada($hora_entrada) {
        $this->hora_entrada = $hora_entrada;
    }
    public function setHora_salida($hora_salida) {
        $this->hora_salida = $hora_salida;
    }
    public function setId_mesa($id_mesa) {
        $this->id_mesa = $id_mesa;
    }
}
//FernandezVico

?>