<?php

class reservaDAO {
    // ATRIBUTOS
    private $pdo;

    // CONSTRUCTOR
    public function __construct(){
        include '../db/connection.php';
        $this->pdo=$pdo;
    }

    public function readReservas() {
        $query = "SELECT * FROM reserva ORDER BY dia DESC;";
        $sentencia=$this->pdo->prepare($query);
        $sentencia->execute();
        $lista_reservas=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($lista_reservas as $reserva) {
            echo "<tr>";
            
            echo "<td style='text-align: center'>{$reserva['id_reserva']}</td>";
            echo "<td style='text-align: center'>{$reserva['dia']}</td>";
            echo "<td style='text-align: center'>{$reserva['franja']}</td>";
            echo "<td style='text-align: center'>{$reserva['id_mesa']}</td>";
            echo "<td style='text-align: center'>{$reserva['nombre_comensal']}</td>";
            echo "<td style='text-align: center'>{$reserva['num_comensales']}</td>";
            echo "<td style='text-align: center'>{$reserva['id_camarero']}</td>";
           
            echo "</tr>";
        }
        return $lista_reservas;
    }

}

?>