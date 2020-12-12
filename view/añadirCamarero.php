<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/zonaRestaurante.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../js/code.js"></script>
    <title>Añadir trabajador</title>
</head>
<body>

<div class="nav"> 
    <a class='atras' href='./index.admin.php'>Atrás</a>
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
        if(isset($_POST['nombre_camarero'])) {
            require_once '../model/camareroDAO.php';
            $camareroDAO = new camareroDAO();
            $camareroDAO->añadir();
            header('LOCATION: ../view/index.admin.php');
        }
    ?>

<div class="editar">
    <form action="../view/añadirCamarero.php" class="reservaForm" method="POST" onsubmit="return validacionPass(event)">
        <label for="nombre_camarero">Nombre:</label><br>
        <input type="text" id="nombre_camarero" name="nombre_camarero" required><br>
        
        <label for="contrasenya">Contraseña:</label><br>
        <input type="text" id="contrasenya" name="contrasenya" required><br>
    
        <label for="contrasenyaVal">Repite contraseña:</label><br>
        <input type="text" id="contrasenyaVal" name="contrasenyaVal" required><br>
        
        <label for="rol">Cargo:</label><br>
        <select id="rol" name="rol" style="margin:0;">
            <option value='0'>Camarero</option>
            <option value='1'>Mantenimiento</option>
            <option value='2'>Administrador</option>
        </select>
        <p id="msgErr"></p>
        <input class="edit" type="submit" value="Crear">
    </form> 
    </div>

</body>
</html>