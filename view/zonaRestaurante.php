<html>
    <head>
        <title>Pagina Principal | Restaurante</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <?php
            require_once '../controller/sessionController.php';
        ?>

        <ul>
        <li><a href='../view/zonaRestaurante.php?espacio=VIPs'>VIPs</a></li>
        <li><a href='../view/zonaRestaurante.php?espacio=Terraza'>Terraza</a></li>
        <li><a href='../view/zonaRestaurante.php?espacio=Comedor'>Comedor</a></li>
        <li class="historico"><a href="./regMesaHorarios.php">Historico</a></li>
        </ul>
            
        <?php
        include_once '../model/mesaDAO.php';

        $mesaDAO = new MesaDAO();
        echo "<table id='table'>";
        echo "<tbody>";
        echo $mesaDAO->getMesas();
        echo "</table>";

        if(isset($_REQUEST['id_mesa'])) {
            if($_REQUEST['disp_mesa'] == "Libre") {
                $mesaDAO->updateSalida();
            } else if ($_REQUEST['disp_mesa'] == "Ocupada") {
                $mesaDAO->updateEntrada();
            } else {
                // TODO
            }
        }
        ?>

        </tbody>
        </table>
    </body>
</html>