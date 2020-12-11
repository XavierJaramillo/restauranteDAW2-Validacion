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

    public function crearReserva() {
        try {
            include_once '../controller/sessionController.php';
            include_once './camarero.php';

            $this->pdo->beginTransaction();

            //Variables reserva
            $dia = $_REQUEST['dia'];
            $hora = $_REQUEST['hora'];
            $id_mesa = $_REQUEST['id_mesa'];
            $espacio = $_REQUEST['tipo_espacio'];
            if(isset($_REQUEST['nombre_comensal'])) {
                $nombre_comensal = $_REQUEST['nombre_comensal'];
            } else {
                $nombre_comensal = "ClienteDefault";
            }
            $url = "../view/zonaRestaurante.php?espacio={$espacio}";
            $id_camarero = $_SESSION['camarero']->getId_camarero();

            $query="INSERT INTO `reserva` (`dia`, `franja`, `id_mesa`, `nombre_comensal`, `id_camarero`) VALUES (?, ?, ?, ?, ?);";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$dia);
            $sentencia->bindParam(2,$hora);
            $sentencia->bindParam(3,$id_mesa);
            $sentencia->bindParam(4,$nombre_comensal);
            $sentencia->bindParam(5,$id_camarero);
            $sentencia->execute();

            //Variables mesa
            $id_mesa = $_REQUEST['id_mesa'];
            $capacidad_mesa = $_REQUEST['capacidad_mesa'];
            if(isset($_REQUEST['disp_mesa'])) {
                $disp_mesa = $_REQUEST['disp_mesa'];
            } else {
                $disp_mesa = "Disponible";
            }
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
            header('Location: ../view/errorMesa.php');
            echo $e;
        }
    }

    // METODO PARA OBTENER EL CUERPO DE LA TABLA (SITUADA EN zonaRestaurante.php)
    // GRACIAS A ESTE METODO, PODEMOS FILTRAR LAS MESAS QUE QUEREMOS MOSTRAR EN LA TABLA SEGUN EL ESPACIO
    // EN EL CUAL SE ENCUENTRA LA MESA
    public function getMesas() {
        try {
            include_once '../controller/sessionController.php';

            $con = 0;

            if(isset($_REQUEST['espacio'])){
                $tipoEspacio=$_REQUEST['espacio'];
            } else {
                $tipoEspacio="Terraza";
            }

            if(isset($_GET['filtro_fecha'])) {
                if($_GET['filtro_fecha'] == "") {
                    $fecha = Date('y-m-d');
                } else {
                    $fecha = $_GET['filtro_fecha'];
                }
            } else {
                $fecha = Date('y-m-d');
            }

            $query = "SELECT m.*, qry.dia, qry.franja1, qry.franja2, qry.franja3, qry.franja4, qry.nombre_camarero 
            FROM espacio e INNER JOIN mesas m ON m.id_espacio = e.id_espacio 
            LEFT JOIN( SELECT r.dia, r.id_mesa, c.nombre_camarero, 
            MAX( CASE WHEN r.franja = '13:00h-14:00h' THEN r.franja END ) AS franja1, 
            MAX( CASE WHEN r.franja = '14:00h-15:00h' THEN r.franja END ) AS franja2, 
            MAX( CASE WHEN r.franja = '21:00h-22:00h' THEN r.franja END ) AS franja3, 
            MAX( CASE WHEN r.franja = '22:00h-23:00h' THEN r.franja END ) AS franja4 FROM reserva r 
            INNER JOIN camareros c ON r.id_camarero = c.id_camarero 
            WHERE r.dia = ? GROUP BY r.dia ) qry ON qry.id_mesa = m.id_mesa 
            WHERE tipo_espacio = ?";

            $sentencia = $this->pdo->prepare($query);
            $sentencia->bindParam(1, $fecha);
            $sentencia->bindParam(2, $tipoEspacio);
            $sentencia->execute();
            $lista_mesas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            $rol_user = $_SESSION['camarero']->getRol();
            $index = 0;

            foreach($lista_mesas as $mesa) {
                // COMPROBAMOS EL ESTADO DE LA MESA
                $idMesa = $mesa['id_mesa'];
                $estado = $mesa['disp_mesa'];
                if($con%4==0){
                    echo "<tr>";
                }
                $index++;
                $con++;
                // IMPRIMIMOS LAS MESAS SEGUN SU ESTADO
                    if($estado == "Disponible") {
                        echo "<td>";
                        echo "<p class='pHistorico' id='aHistorico{$index}' onmouseover='displayInfo({$index})' onmouseout='quitInfo({$index})'><img src='../img/history.png' alt='historial'></a></p>";
                        echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesa.png'></img></a>";
                        echo "<p>Nº mesa: $idMesa</p>";
                        $this->imprimirInfo($mesa, $index);
                        echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                        echo "</td>";
                    } else {
                        if($rol_user == 1 || $rol_user == 2) {
                            echo "<td>";
                            echo "<p class='pHistorico'><a class='aHistorico' href='./regMesa.php?id_mesa=$idMesa'><img src='../img/history.png' alt='historial'></a></p>";
                            echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesaReparacion.png'></img></a>";
                            echo "<p>Nº mesa: $idMesa</p>";
                            echo "</td>";
                        } else {
                            echo "<td>";
                            echo "<p class='pHistorico'><a class='aHistorico' href='./regMesa.php?id_mesa=$idMesa'><img src='../img/history.png' alt='historial'></a></p>";
                            echo "<a href='#'><img src='../img/mesaReparacion.png'></img></a>";
                            echo "<p>Nº mesa: $idMesa</p>";
                            echo "</td>";
                        }
                    }
                
                if($con%4==0){
                    echo "</tr>";
                }
            }
        } catch (Exception $e) {
            echo $e;
        }   
    }

    public function imprimirInfo($mesa, $index) {
        echo "<div class='info' id='caja$index'>";
        if($mesa['franja1'] != NULL) {
            echo "<p>Franja1: Ocupada/{$mesa['nombre_camarero']}</p>";
        } else {
            echo "<p>Franja1: Libre</p>";
        }
        if($mesa['franja2'] != NULL) {
            echo "<p>Franja2: Ocupada/{$mesa['nombre_camarero']}</p>";
        } else {
            echo "<p>Franja2: Libre</p>";
        }
        if($mesa['franja3'] != NULL) {
            echo "<p>Franja3: Ocupada/{$mesa['nombre_camarero']}</p>";
        } else {
            echo "<p>Franja3: Libre</p>";
        }
        if($mesa['franja4'] != NULL) {
            echo "<p>Franja4: Ocupada/{$mesa['nombre_camarero']}</p>";
        } else {
            echo "<p>Franja4: Libre</p>";
        }
        echo "</div>";
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