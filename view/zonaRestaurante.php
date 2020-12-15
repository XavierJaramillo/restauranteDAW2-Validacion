<html>
    <head>
        <title>Pagina Principal | Restaurante</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/zonaRestaurante.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="../js/code.js"></script>
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
            <form class="filtro" action="./zonaRestaurante.php" method="get">
            <ul>
                <?php
                    if($_SESSION['camarero']->getRol() == 2) {
                        echo "<li> <a href='./index.admin.php'>Admin</a> </li>";
                    }
                ?>
                
                <li>
                    <label for="tipo_espacio">Filtro espacio:</label>
                    <select id="tipo_espacio" name="tipo_espacio" style="margin:0;">
                        <?php
                            if($_REQUEST['tipo_espacio'] == "Terraza") {
                                echo "<option value='Terraza'>Terraza</option>";
                                echo "<option value='VIPs'>VIPs</option>";
                                echo "<option value='Comedor'>Comedor</option>";
                            } else if($_REQUEST['tipo_espacio'] == "Comedor") {
                                echo "<option value='Comedor'>Comedor</option>";
                                echo "<option value='Terraza'>Terraza</option>";
                                echo "<option value='VIPs'>VIPs</option>";
                            } else if($_REQUEST['tipo_espacio'] == "VIPs") {
                                echo "<option value='VIPs'>VIPs</option>";
                                echo "<option value='Comedor'>Comedor</option>";
                                echo "<option value='Terraza'>Terraza</option>";
                            }
                        ?>
                    </select>
                </li>

                <li>
                    <label>Filtro fecha:</label><input type="date" name="filtro_fecha" id="filtro_fecha">
                    <input type="submit" value="Enviar">
                </li>
                
            </ul>
        </form>
        </div>
        
        <?php
        include_once '../model/mesaDAO.php';

        // INSTANCIAMOS LA CLASE MESADAO PARA PODER USAR SUS METODOS
        $mesaDAO = new MesaDAO();

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

        echo "<table id='table' style='margin-left: auto;margin-right: auto;border-spacing: 55px'>";
        echo "<tbody>";
        echo $mesaDAO->getMesas();
        echo "</table>";
        ?>

        </tbody>
        </table>
    </body>
</html>