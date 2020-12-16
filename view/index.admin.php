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
    <a class='atras' href='./zonaRestaurante.php?tipo_espacio=Terraza'>Atrás</a>
        <!-- CONTROL DE SESIONES Y BOTONES -->
        <?php
            require_once '../controller/sessionController.php';
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
                <label for="tipo_espacio">Filtro espacio:</label>
                <select id="tipo_espacio" name="tipo_espacio" style="margin:0;">
                    <option value='Terraza'>Terraza</option>
                    <option value='Comedor'>Comedor</option>
                    <option value='VIPs'>VIPs</option>
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
    require_once '../model/camareroDAO.php';
    $camareroDAO = new camareroDAO();

    echo "<table id='tablaCamareros' style='border: 1px solid black'>";
    echo "<tr>";
    echo "<form action='index.admin.php' method='POST'>";
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