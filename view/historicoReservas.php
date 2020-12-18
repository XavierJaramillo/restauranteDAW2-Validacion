<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/zonaRestaurante.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="../js/code.js"></script>
        <title>Reservas historico | Restaurante</title>
    </head>
    <body>
        <div class="nav">
            <a class='atras' href='./zonaRestaurante.php?tipo_espacio=Terraza&filtro_fecha='>Atrás</a>
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
                    <select id="tipo_espacio" name="tipo_espacio" style="margin:0;">
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

        <div class="reservasHistorico">
        <?php
            require_once '../model/reservaDAO.php';
            $reservaDAO = new reservaDAO();
            
            echo "<table id='tablaCamareros'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Día</th>";
            echo "<th>Hora</th>";
            echo "<th>Mesa</th>";
            echo "<th>Nombre reserva</th>";
            echo "<th>Comensales</th>";
            echo "<th>Encargado</th>";
            echo "</tr>";
            
            $reservaDAO->readReservas();

            echo "</table>";

        ?>
        </div>
    </body>
</html>