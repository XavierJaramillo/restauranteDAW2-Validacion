<?php
//MartinezFalconi

//JaramilloVives
require_once 'mesa.php';
class MesaDAO {
    private $pdo;

    public function __construct(){
        include '../db/connection.php';
        $this->pdo=$pdo;
    }

    public function getMesas() {
        $tipoEspacio = $_REQUEST['espacio'];
        $query = "SELECT * FROM mesas INNER JOIN espacio ON mesas.id_espacio = espacio.id_espacio LEFT JOIN camareros
        ON mesas.id_camarero = camareros.id_camarero WHERE tipo_espacio = ?;";
        $sentencia = $this->pdo->prepare($query);
        $sentencia->bindParam(1, $tipoEspacio);
        $sentencia->execute();
        $lista_mesas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        foreach($lista_mesas as $mesa) {
            // COMPROBAMOS EL ESTADO DE LA MESA
            $idMesa = $mesa['id_mesa'];
            $estado = $mesa['disp_mesa'];

            echo "<tr>";
            // IMPRIMIMOS LAS MESAS SEGUN SU ESTADO
            if($estado == "Libre") {
                echo "<td>";
                echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesa.png'></img></a>";
                echo "<p>ID: $idMesa</p>";
                echo "<p>Camarero: {$mesa['nombre_camarero']}</p>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            } else if ($estado == "Ocupada") {
                echo "<td>";
                echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesaOcupada.png'></img></a>";
                echo "<p>Ocupada!</p>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            } else {
                echo "<td>";
                echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesaReparacion.png'></img></a>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            }
            echo "</tr>";
            
        }
    }

    public function getDatosForm() {
        $id_mesa = $_REQUEST['id_mesa'];
    }
}
//FernandezVico

?>