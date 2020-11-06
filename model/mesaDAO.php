<?php
require_once 'mesa.php';
class MesaDAO {
    // ATRIBUTOS
    private $pdo;

    // CONSTRUCTOR
    public function __construct(){
        include '../db/connection.php';
        $this->pdo=$pdo;
    }

    // CREAMOS UN GETTER PARA EL PDO
    public function getPDO() {
        return $this->pdo;
    }

    // METODO PARA OBTENER EL CUERPO DE LA TABLA (SITUADA EN zonaRestaurante.php)
    // GRACIAS A ESTE METODO, PODEMOS FILTRAR LAS MESAS QUE QUEREMOS MOSTRAR EN LA TABLA SEGUN EL ESPACIO
    // EN EL CUAL SE ENCUENTRA LA MESA
    public function getMesas() {
        $con = 0;
        $idMantenimiento = $_SESSION['camarero']->getIdMantenimiento();

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
                echo "<p class='pHistorico'><a class='aHistorico' href='./regMesa.php?id_mesa=$idMesa'><img src='../img/history.png' alt='historial'></a></p>";
                echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesa.png'></img></a>";
                echo "<p>Nº mesa: $idMesa</p>";
                echo "<p>Camarero asignado: {$mesa['nombre_camarero']}</p>";
                echo "<p>Comensal/es: 0</p>";
                echo "<p>Libre</p>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            } else if ($estado == "Ocupada") {
                echo "<td>";
                echo "<p class='pHistorico'><a class='aHistorico' href='./regMesa.php?id_mesa=$idMesa'><img src='../img/history.png' alt='historial'></a></p>";
                echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesaOcupada.png'></img></a>";
                echo "<p>Nº mesa: $idMesa</p>";
                echo "<p>Camarero asignado: {$mesa['nombre_camarero']}</p>";
                echo "<p>Comensal/es: {$mesa['capacidad_mesa']}</p>";
                echo "<p>Ocupada</p>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            } else {
                echo "<td>";
                echo "<p class='pHistorico'><a class='aHistorico' href='./regMesa.php?id_mesa=$idMesa'><img src='../img/history.png' alt='historial'></a></p>";
                // echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesaReparacion.png'></img></a>";
                if ($idMantenimiento != NULL){
                    echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesaReparacion.png'></img></a>";
                } else {
                    echo "<img src='../img/mesaReparacion.png'></img>";
                }
                echo "<p>Nº mesa: $idMesa</p>";
                echo "<p>Camarero asignado: {$mesa['nombre_camarero']}</p>";
                echo "<p>Comensal/es: {$mesa['capacidad_mesa']}</p>";
                echo "<p>Reparación</p>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            }
            if($con%4==0){
                echo "</tr>";
            }
        }
    }

    // CON ESTE METODO CONTROLAMOS:
    // 1- QUE CAMARERO SE ESTA HACIENDO CARGO DE LA MESA
    // 2- PASAR EL ESTADO DE LA MESA A OCUPADO
    // 3- CUANTOS COMENSALES TENEMOS EN LA MESA
    // 4- LA HORA DE ENTRADA DE LOS COMENSALES
    public function updateEntrada() {
        try {
            include '../controller/sessionController.php';
            include './camarero.php';
            $this->pdo->beginTransaction();
            $id_camarero = $_SESSION['camarero']->getId_camarero();
            $id_mesa = $_REQUEST['id_mesa'];
            $disp_mesa = $_REQUEST['disp_mesa'];
            $capacidad_mesa = $_REQUEST['capacidad_mesa'];
            $espacio = $_REQUEST['tipo_espacio'];

            $url = "../view/zonaRestaurante.php?espacio={$espacio}";

            $query="UPDATE mesas SET mesas.capacidad_mesa = ?, mesas.id_camarero = ?, mesas.disp_mesa = ? WHERE id_mesa = ?;";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$capacidad_mesa);
            $sentencia->bindParam(2,$id_camarero);
            $sentencia->bindParam(3,$disp_mesa);
            $sentencia->bindParam(4,$id_mesa);
            $sentencia->execute();

            $query = "INSERT INTO horario (hora_entrada, id_mesa) VALUES (NOW(), ?);";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$id_mesa);
            echo $query;
            $sentencia->execute();
            
            $this->pdo->commit();
            header('Location: '.$url);
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo $e;
        }
    }
    
    // CON ESTE METODO CONTROLAMOS:
    // 1- QUITAR EL ENCARGADO DE LA MESA
    // 2- PASAR EL ESTADO DE LA MESA A LIBRE
    // 3- PONER 0 COMENSALES EN LA MESA
    // 4- LA HORA DE SALIDA DE LOS COMENSALES
    public function updateSalida() {
        try {
            $this->pdo->beginTransaction();
            $id_mesa = $_REQUEST['id_mesa'];
            $disp_mesa = $_REQUEST['disp_mesa'];
            $espacio = $_REQUEST['tipo_espacio'];
            
            $url = "../view/zonaRestaurante.php?espacio={$espacio}";
            
            $query="UPDATE mesas SET mesas.capacidad_mesa = 0, mesas.id_camarero = NULL, mesas.disp_mesa = ? WHERE id_mesa = ?;";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$disp_mesa);
            $sentencia->bindParam(2,$id_mesa);
            $sentencia->execute();
            
            $query = "UPDATE horario, (SELECT MAX(hora_entrada) AS maximo FROM horario WHERE id_mesa = ?) AS tmax
            SET horario.hora_salida = NOW()
            WHERE horario.hora_entrada=tmax.maximo AND horario.id_mesa=?";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$id_mesa);
            $sentencia->bindParam(2,$id_mesa);
            $sentencia->execute();

            $this->pdo->commit();
            header('Location: '.$url);
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo $e;
        }
    }

    // ESTE METODO NOS PERMITE VER EL HISTORIAL DE LA MESA, ES DECIR, HORAS/DIAS DE ENTRADA Y SALIDA
    public function viewHistorical() {
        try {
            $this->pdo->beginTransaction();
            $id_mesa = $_REQUEST['id_mesa'];

            // CON ESTA QUERY NUESTRO OBJETIVO ES TENER UN CUERPO DE TABLA DINÁMICA
            $query = "SELECT hora_entrada, hora_salida FROM horario WHERE id_mesa = ?";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$id_mesa);
            $sentencia->execute();
            $lista_horas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            echo "<tr><td colspan='3' style='text-align: center; font-size: 55px'>Mesa nº: {$id_mesa}</td></tr>";

            // EN EL CASO DE ESTAR VACIA LA "LISTA" NOS IMPRIME UN MENSAJE, DE LO CONTRARIO, NOS MUESTRA EL HISTORICO
            if($lista_horas==null){
                echo "<table id='tableHistorical' style='border-spacing: 55px'>";
                echo "<tr><td colspan='3' style='text-align: center; font-size: 55px'>Esta mesa no tiene registros.</td></tr>";
                echo "</table>";
            } else {
                // MOSTRAMOS TODOS LOS REGISTROS DE LA MESA
                foreach ($lista_horas as $hora) {
                    echo "<tr>";
                    echo "<td>Hora entrada: {$hora['hora_entrada']}</td>";
                    echo "<td>Hora salida: {$hora['hora_salida']}</td>";
                    echo "</tr>";
                }
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo $e;
        }
    }

    // ESTE METODO PERMITIRA A LAS PERSONAS DE MANTENIMIENTO MODIFICAR EL ESTADO DE LA MESA A REPARACIÓN
    public function fixMesa(){
        try {
            $this->pdo->beginTransaction();
            $id_mesa = $_REQUEST['id_mesa'];
            $espacio = $_REQUEST['tipo_espacio'];
            $capacidad_max = $_REQUEST['capacidad_max'];
            $id_camarero = $_SESSION['camarero']->getId_camarero();
            $idMantenimiento = $_SESSION['camarero']->getIdMantenimiento();

            $url = "../view/zonaRestaurante.php?espacio={$espacio}";

            if ($idMantenimiento != NULL) {
                $query = "UPDATE mesas SET mesas.capacidad_max = ?, mesas.capacidad_mesa = 0, mesas.id_camarero = ?, mesas.disp_mesa = 'Reparacion' WHERE id_mesa = ?";
                
                $sentencia=$this->pdo->prepare($query);
                $sentencia->bindParam(1,$capacidad_max);
                $sentencia->bindParam(2,$id_camarero);
                $sentencia->bindParam(3,$id_mesa);
                
                $sentencia->execute();
                $this->pdo->commit();
                header('Location: '.$url);
            }else {
                echo "<p class='msgMantenimiento'>Usted no es de mantenimiento</p>";
                echo "<div class='btnVolverDiv'><a href='../view/zonaRestaurante.php?espacio={$espacio}' class='btnVolver'>Volver</a></div>";
            }

        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo $e;
        }
    }
}

?>