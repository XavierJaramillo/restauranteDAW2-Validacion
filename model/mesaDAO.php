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

    public function getPDO() {
        return $this->pdo;
    }

    public function getMesas() {
        $con = 0;
        if(isset($_REQUEST['espacio'])){
            $tipoEspacio=$_REQUEST['espacio'];
        } else {
            $tipoEspacio="Libre";
        }
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
            if($con%4==0){
                echo "<tr>";
            }
            $con++;
            // IMPRIMIMOS LAS MESAS SEGUN SU ESTADO
            if($estado == "Libre") {
                echo "<td>";
                echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesa.png'></img></a>";
                echo "<p>Nº mesa: $idMesa</p>";
                echo "<p>Camarero: {$mesa['nombre_camarero']}</p>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            } else if ($estado == "Ocupada") {
                echo "<td>";
                echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesaOcupada.png'></img></a>";
                echo "<p>Nº mesa: $idMesa</p>";
                echo "<p>Comensal/es: {$mesa['capacidad_mesa']}</p>";
                echo "<p>Ocupada!</p>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            } else {
                echo "<td>";
                echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesaReparacion.png'></img></a>";
                echo "<p>Nº mesa: $idMesa</p>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            }
            if($con%4==0){
                echo "</tr>";
            }
        }
    }

    public function update() {
        try {
            $this->pdo->beginTransaction();
            $id_mesa = $_REQUEST['id_mesa'];
            $disp_mesa = $_REQUEST['disp_mesa'];
            $capacidad_mesa = $_REQUEST['capacidad_mesa'];
            $espacio = $_REQUEST['tipo_espacio'];

            $url = "../view/zonaRestaurante.php?espacio={$espacio}";


            $query="UPDATE mesas SET mesas.capacidad_mesa = ?, mesas.disp_mesa = ? WHERE id_mesa = ?;";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$capacidad_mesa);
            $sentencia->bindParam(2,$disp_mesa);
            $sentencia->bindParam(3,$id_mesa);
            $sentencia->execute();
            
            $this->pdo->commit();
            header('Location: '.$url);

        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo $e;
        }
    }
}
//FernandezVico

?>