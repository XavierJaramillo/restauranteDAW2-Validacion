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
            $dia = $_REQUEST['dia'];
            $hora = $_REQUEST['hora'];
            $id_mesa = $_REQUEST['id_mesa'];
            $espacio = $_REQUEST['tipo_espacio'];
            $url = "../view/zonaRestaurante.php?espacio={$espacio}";

            $query="INSERT INTO `reserva` (`dia`, `franja`, `id_mesa`) VALUES (?, ?, ?);";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$dia);
            $sentencia->bindParam(2,$hora);
            $sentencia->bindParam(3,$id_mesa);
            $sentencia->execute();
            
            header('Location: '.$url);
            
        } catch (Exception $e) {
            header('Location: ../view/errorMesa.php?id='.$id_mesa);
        }
    }

    // METODO PARA OBTENER EL CUERPO DE LA TABLA (SITUADA EN zonaRestaurante.php)
    // GRACIAS A ESTE METODO, PODEMOS FILTRAR LAS MESAS QUE QUEREMOS MOSTRAR EN LA TABLA SEGUN EL ESPACIO
    // EN EL CUAL SE ENCUENTRA LA MESA
    public function getMesas() {
        try {
            $con = 0;

        if(isset($_REQUEST['espacio'])){
            $tipoEspacio=$_REQUEST['espacio'];
        } else {
            $tipoEspacio="Libre";
        }

        if(isset($_GET['filtro_fecha'])) {
            $fecha = "'".$_GET['filtro_fecha']."'";
        } else {
            $fecha = "CURDATE()";
        }

        $query = "SELECT m.*, c.*, qry.dia, qry.franja1, qry.franja2, qry.franja3, qry.franja4 
        FROM espacio e 
        INNER JOIN mesas m ON m.id_espacio = e.id_espacio 
        LEFT JOIN camareros c ON m.id_camarero = c.id_camarero 
        LEFT JOIN (SELECT r.dia, r.id_mesa, MAX( CASE WHEN r.franja = '13:00h-14:00h' THEN r.franja END ) AS franja1, 
        MAX( CASE WHEN r.franja = '14:00h-15:00h' THEN r.franja END ) AS franja2, 
        MAX( CASE WHEN r.franja = '21:00h-22:00h' THEN r.franja END ) AS franja3, 
        MAX( CASE WHEN r.franja = '22:00h-23:00h' THEN r.franja END ) AS franja4 
        FROM reserva r WHERE r.dia = CURDATE() GROUP BY r.dia) qry ON qry.id_mesa = m.id_mesa 
        WHERE tipo_espacio = 1";

        $sentencia = $this->pdo->prepare($query);
        $sentencia->bindParam(1, $tipoEspacio);
        $sentencia->bindParam(2, $fecha);
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
                echo "<td>";
                echo "<p class='pHistorico'><a class='aHistorico' href='./regMesa.php?id_mesa=$idMesa'><img src='../img/history.png' alt='historial'></a></p>";
                echo "<a href='../view/editMesa.php?id_mesa={$idMesa}'><img src='../img/mesa.png'></img></a>";
                echo "<p>Nº mesa: $idMesa</p>";
                echo "<p>Camarero asignado: {$mesa['nombre_camarero']}</p>";
                echo "<p>Comensal/es: 0</p>";
                echo "<p>Franja 1: {$mesa['franja1']} </p>";
                echo "<p>Capacidad máxima: {$mesa['capacidad_max']} personas</p>";
                echo "</td>";
            
            if($con%4==0){
                echo "</tr>";
            }
        }
        } catch (Exception $e) {
            echo $e;
        }
        
    }

    public function filtrarMesas() {
        $query = "SELECT r.dia, m.id_mesa, 
        MAX( CASE WHEN r.franja = '13:00h-14:00h' THEN r.franja END ) AS franja1, 
        MAX( CASE WHEN r.franja = '14:00h-15:00h' THEN r.franja END ) AS franja2, 
        MAX( CASE WHEN r.franja = '21:00h-22:00h' THEN r.franja END ) AS franja3, 
        MAX( CASE WHEN r.franja = '22:00h-23:00h' THEN r.franja END ) AS franja4 
        FROM reserva r 
        INNER JOIN mesas m ON r.id_mesa = m.id_mesa 
        WHERE r.dia = '?' 
        GROUP BY m.id_mesa, r.dia;";
        $sentencia = $this->pdo->prepare($query);
        $sentencia->bindParam(1, $tipoEspacio);
        $sentencia->execute();
        $filtro_mesas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    // CON ESTE METODO CONTROLAMOS:
    // 1- QUE CAMARERO SE ESTA HACIENDO CARGO DE LA MESA
    // 2- PASAR EL ESTADO DE LA MESA A OCUPADO
    // 3- CUANTOS COMENSALES TENEMOS EN LA MESA
    // 4- LA HORA DE ENTRADA DE LOS COMENSALES
    public function updateEntrada() {
        try {
            include_once '../controller/sessionController.php';
            include_once './camarero.php';
            $this->pdo->beginTransaction();
            $id_camarero = $_SESSION['camarero']->getId_camarero();
            $id_mesa = $_REQUEST['id_mesa'];
            $disp_mesa = $_REQUEST['disp_mesa'];
            $capacidad_mesa = $_REQUEST['capacidad_mesa'];
            $espacio = $_REQUEST['tipo_espacio'];
            $data_inicio = $_REQUEST['data_inicio'];
            $data_final = $_REQUEST['data_final'];
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
            $sentencia->execute();

            $query = "INSERT INTO reserva (data_inicio, data_final) VALUES (?, ?);";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$data_inicio);
            $sentencia->bindParam(2,$data_final);
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