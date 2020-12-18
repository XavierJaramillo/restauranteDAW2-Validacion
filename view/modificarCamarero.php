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
                <label>Filtro fecha:</label>
                <input type="date" name="filtro_fecha" id="filtro_fecha" 
                    value="<?php 
                        if(!empty($_GET['filtro_fecha'])) {
                            $fecha = $_GET['filtro_fecha'];
                        } else {
                            $fecha = Date('Y-m-d');
                        }
                        echo $fecha 
                    ?>">
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