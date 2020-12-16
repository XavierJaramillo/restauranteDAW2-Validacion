<?php

class espacioDAO {
    // ATRIBUTOS
    private $pdo;

    // CONSTRUCTOR
    public function __construct() {
        include_once '../db/connection.php';
        $this->pdo=$pdo;
    }

    public function getEspacios() {
        require_once '../model/espacio.php';

        $espacio = $_REQUEST['tipo_espacio'];

        $query = "SELECT * FROM `espacio` ORDER BY FIELD(tipo_espacio, ?) DESC";
        $sentencia = $this->pdo->prepare($query);
        $sentencia->bindParam(1, $espacio);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>