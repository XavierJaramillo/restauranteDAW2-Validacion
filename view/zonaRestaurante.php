<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/zonaRestaurante.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="../js/code.js"></script>
        <title>Página Principal | Restaurante</title>
    </head>
    <body>
        <div class="nav"> 
            <!-- CONTROL DE SESIONES Y BOTONES -->
            <?php
                require_once '../controller/sessionController.php';
            ?>
        </div>

        <div class="subnav">
            <!-- SUBNAV CON LINK A LOS DIFERENTES ESPACIOS -->
            <form action="./zonaRestaurante.php" method="get">
            <ul>
                <?php
                    if($_SESSION['camarero']->getRol() == 2) {
                        echo "<li> <a href='./index.admin.php'>Admin</a> </li>";
                    }
                ?>
                
                <li>
                    <a href='./historicoReservas.php?tipo_espacio=<?php echo $_REQUEST['tipo_espacio'] ?>'>Reservas</a>
                </li>

                <li>
                    <label for="tipo_espacio">Espacio </label>
                    <select id="tipo_espacio" name="tipo_espacio">
                        <?php
                            require_once '../model/espacioDAO.php';

                            $espacioDAO = new espacioDAO();
                            $listaEspacios = $espacioDAO->getEspacios();
                            
                            foreach ($listaEspacios as $espacio) {
                                    echo "<option value='{$espacio['tipo_espacio']}'>{$espacio['tipo_espacio']}</option>";
                            }
                        ?>
                    </select>
                </li>

                <li>
                    <label>Fecha </label>
                    <input type="date" name="filtro_fecha" id="filtro_fecha" 
                    value="<?php 
                        if(!empty($_GET['filtro_fecha'])) {
                            $fecha = $_GET['filtro_fecha'];
                        } else {
                            $fecha = Date('Y-m-d');
                        }
                        echo $fecha 
                    ?>">
                    <input type="submit" value="Buscar">
                </li>
                
            </ul>
        </form>
        </div>
        
        <?php
        require_once '../model/mesaDAO.php';
        require_once '../model/reservaDAO.php';
        // INSTANCIAMOS LA CLASE MESADAO PARA PODER USAR SUS METODOS
        $mesaDAO = new MesaDAO();
        $reservaDAO = new ReservaDAO();

        if(isset($_REQUEST['habilitar'])) {
            if($_REQUEST['habilitar'] == "t") {
                $mesaDAO->habilitarMesa("Disponible");
                header("Location: ../view/zonaRestaurante.php?tipo_espacio={$_REQUEST['tipo_espacio']}");
            } else if($_REQUEST['habilitar'] == "f") {
                $mesaDAO->habilitarMesa("Reparacion");
                header("Location: ../view/zonaRestaurante.php?tipo_espacio={$_REQUEST['tipo_espacio']}");
            }
        }

        // CONTROLAMOS QUE VARIABLES ESTAN INICIALIZADAS Y SEGÚN ESTO, LLAMAMOS AL METODO CORRESPONDIENTE
        // EL CUAL CONTROLA EL CONTENIDO DE LA TABLA
        if(isset($_REQUEST['id_mesa'])) {
            if(isset($_REQUEST['capacidad_mesa'])) {
                $mesaDAO->crearReserva();
            }
        }

        // CONTROLAMOS SI LA VARIABLE ID ESTA INICIALIZADA POR METODO GET, PARA ASI LLAMAR AL METODO QUE
        // ELIMINARÁ LA RESERVA ESPECIFICADA
        if(isset($_REQUEST['idMesa'])) {
            $reservaDAO->eliminarReserva();
        }

        echo "<table id='table' style='margin-left: auto;margin-right: auto;border-spacing: 55px'>";
        echo "<tbody>";
        echo $mesaDAO->getMesas();
        echo "</table>";
        ?>

        </tbody>
        </table>
    </body>
</html>