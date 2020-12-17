<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/zonaRestaurante.css">
    <link rel="stylesheet" type="text/css" href="../css/editTrabajador.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../js/code.js"></script>
    <title>Modificar trabajador | Restaurante</title>
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
    require_once '../model/camareroDAO.php';
    $c = new camareroDAO();

    $id = $_GET['id_camarero'];
    $trabajador = $c->getCamarero($id);
    ?>
    
    <div class="editar">
        <form action="../view/index.admin.php" class="trabForm" method="POST" onsubmit="return validacionPass(event)">
        <h1>Modificar trabajador: <?php echo $_REQUEST['id_camarero'] ?>.</h1>
        <input type="text" id="id_camarero_modificar" name="id_camarero_modificar" style="display:none" value="<?php echo $trabajador['id_camarero'];?>">
        <input type="text" id="mod" name="mod" style="display:none" value="true">

        <label for="nombre_camarero">Nombre:</label><br>
        <input type="text" id="nombre_camarero" name="nombre_camarero" value="<?php echo $trabajador['nombre_camarero'];?>" required><br>
        
        <label for="contrasenya">Contraseña:</label><br>
        <input type="password" id="contrasenya" name="contrasenya" required><br>

        <label for="contrasenyaVal">Repite contraseña:</label><br>
        <input type="password" id="contrasenyaVal" name="contrasenyaVal" required><br>

        <label for="rol">Cargo:</label><br>
        <select id="rol" name="rol" required>
            <?php
                if($trabajador['rol'] == "0") {
                    echo "<option value='0'>Camarero</option>";
                    echo "<option value='1'>Mantenimiento</option>";
                    echo "<option value='2'>Administrador</option>";
                } else if($trabajador['rol'] == "1") {
                    echo "<option value='1'>Mantenimiento</option>";
                    echo "<option value='0'>Camarero</option>";
                    echo "<option value='2'>Administrador</option>";
                } else if($trabajador['rol'] == "2") {
                    echo "<option value='2'>Administrador</option>";
                    echo "<option value='0'>Camarero</option>";
                    echo "<option value='1'>Mantenimiento</option>";
                }
            ?>
        </select>
        
        <p id="msgErr"></p>

        <input class="actualizar" type="submit" value="Actualizar">
        </form> 
    </div>
    
</body>
</html>