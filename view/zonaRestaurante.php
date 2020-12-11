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
            <!-- <img class="logo" src="../img/logo.png" alt="Logo restaurante"> -->
            <?php
                require_once '../controller/sessionController.php';
            ?>
        </div>

        <div class="subnav">
            <!-- SUBNAV CON LINK A LOS DIFERENTES ESPACIOS -->
            <form class="filtro" action="./zonaRestaurante.php" method="get">
            <ul>
                
                <li>
                    <label for="espacio">Filtro espacio:</label>
                    <select id="espacio" name="espacio" style="margin:0;">
                        <?php
                            if($_GET['espacio'] == "Terraza") {
                                echo "<option value='Terraza'>Terraza</option>";
                                echo "<option value='VIPs'>VIPs</option>";
                                echo "<option value='Comedor'>Comedor</option>";
                            } else if($_GET['espacio'] == "Comedor") {
                                echo "<option value='Comedor'>Comedor</option>";
                                echo "<option value='Terraza'>Terraza</option>";
                                echo "<option value='VIPs'>VIPs</option>";
                            } else {
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
        echo "<table id='table' style='margin-left: auto;margin-right: auto;border-spacing: 55px'>";
        echo "<tbody>";
        echo $mesaDAO->getMesas();
        echo "</table>";

        // CONTROLAMOS QUE VARIABLES ESTAN INICIALIZADAS Y SEGÚN ESTO, LLAMAMOS AL METODO CORRESPONDIENTE
        // EL CUAL CONTROLA EL CONTENIDO DE LA TABLA
        if(isset($_REQUEST['id_mesa'])) {
            if($_REQUEST['disp_mesa'] == "Disponible") {
                $mesaDAO->crearReserva();
            }
        }
        ?>

        </tbody>
        </table>
    </body>
</html>