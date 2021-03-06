<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/zonaRestaurante.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Zona admin | Restaurante</title>
</head>
<body>

    <div class="nav"> 
    <a class='atras' href='./zonaRestaurante.php?tipo_espacio=Terraza&filtro_fecha='>Atrás</a>
        <!-- CONTROL DE SESIONES Y BOTONES -->
        <?php
            require_once '../controller/sessionController.php';
            require_once '../controller/adminController.php'
        ?>
    </div>

    <div class="subnav">
        <!-- SUBNAV CON LINK A LOS DIFERENTES ESPACIOS -->
        <form class="filtro" action="./zonaRestaurante.php" method="GET">
        <ul>
            <?php
                if($_SESSION['camarero']->getRol() == 2) {
                    echo "<li> <a href='./index.admin.php'>Admin</a> </li>";
                }
            ?>

            <li>
                <a href='./historicoReservas.php?tipo_espacio=Terraza'>Reservas</a>
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
    require_once '../model/camareroDAO.php';
    $camareroDAO = new camareroDAO();

    echo "<table id='tablaCamareros'>";
    echo "<tr>";
    echo "<th colspan='2'><a class='m' href='../view/añadirCamarero.php'><i class='material-icons'>add_circle_outline</i></a></th>";
    echo "<th>Nombre trabajador</th>";
    echo "<th>Contraseña</th>";
    echo "<th>Cargo</th>";
    echo "</tr>";
    
    if(isset($_GET['baja'])) {
        if($_GET['baja'] == "t") {
            $camareroDAO->bajaCamarero($_GET['id_camarero'], 1);
        } else if($_GET['baja'] == "f") {
            $camareroDAO->bajaCamarero($_GET['id_camarero'], 0);
        }
    }
    
    if(isset($_POST['mod'])) {
        $camareroDAO->modificarCamarero();
    }

    $camareroDAO->readCamareros();

    echo "</table>";

    ?>
    
</body>
</html>