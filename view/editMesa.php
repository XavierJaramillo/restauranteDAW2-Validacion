<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/code.js"></script>
    <link rel="stylesheet" href="../css/zonaRestaurante.css">
    <title>Editar mesa</title>
</head>
<body>
    <div class="nav"> 
        <!-- CONTROL DE SESIONES Y BOTONES -->
        <a class='atras' href='./zonaRestaurante.php?espacio=Terraza'>Atrás</a>
        <?php
        require_once '../controller/sessionController.php';
        ?>
    </div>
    
    <?php
        include_once '../model/mesaDAO.php';
        // INSTANCIAMOS LA CLASE MESADAO PARA PODER USAR SUS METODOS
        $mDAO = new MesaDAO();
        $pdo = $mDAO->getPDO();
        $pdo->beginTransaction();
        $id = $_REQUEST['id_mesa'];

        // CON ESTA CONSULTA QUEREMOS RECOGER TODOS LOS DATOS NECESARIOS PARA AUTORELLENAR EL FORMULARIO
        $query = "SELECT * FROM mesas INNER JOIN espacio ON mesas.id_espacio = espacio.id_espacio WHERE id_mesa = $id;";
        $sentencia = $pdo->prepare($query);
        $sentencia->execute();
        $mesa = $sentencia->fetch(PDO::FETCH_ASSOC);
        $pdo->commit();
    ?>
    <!-- FORMULARIO PARA EDITAR EL ESTADO DE LA MESA -->
    <div class="editar">
        <form action="zonaRestaurante.php" method="POST" onsubmit="return validacionCapacidad()">
        <!-- PONEMOS EL ID DE LA MESA (PERO EN OCULTO PORQUE NO QUEREMOS QUE SEA VISIBLE/EDITABLE) -->
        <input type="text" id="id_mesa" name="id_mesa" style="display:none" value="<?php echo $mesa['id_mesa'];?>">
        
        <label for="tipo_espacio">Tipo espacio:</label><br>
        <input type="text" id="tipo_espacio" name="tipo_espacio" value="<?php echo $mesa['tipo_espacio'];?>" readonly><br>

        <label for="disp_mesa">Disponibilidad:</label><br>
        <select name="disp_mesa" id="disp_mesa">
        <?php

        $idMantenimiento = $_SESSION['camarero']->getIdMantenimiento();
        if($idMantenimiento != NULL && $idMantenimiento != 2) {
            $id = $_REQUEST['id_mesa'];
            $query = "SELECT disp_mesa FROM mesas WHERE id_mesa = $id;";
            $sentencia = $pdo->prepare($query);
            $sentencia->execute();
            $dMesa = $sentencia->fetch(PDO::FETCH_ASSOC);
            $dMesa['disp_mesa'];
            // CONTROLAMOS LAS OPCIONES DEL TAG OPTION, ASÍ CONSEGUIMOS QUE LA PRIMERA OPCIÓN SEA LA ACTUAL DE LA MESA
                if($dMesa['disp_mesa'] == "Libre") {
                    echo "<option value='{$dMesa['disp_mesa']}'>{$dMesa['disp_mesa']}</option>";
                    echo "<option value='Ocupada'>Ocupada</option>";
                    echo "<option value='Reparacion'>Reparación</option>";
                } else if ($dMesa['disp_mesa'] == "Ocupada") {
                    echo "<option value='{$dMesa['disp_mesa']}'>{$dMesa['disp_mesa']}</option>";
                    echo "<option value='Libre'>Libre</option>";
                    echo "<option value='Reparacion'>Reparación</option>";
                } else if ($dMesa['disp_mesa'] == "Reparacion") {
                    echo "<option value='{$dMesa['disp_mesa']}'>{$dMesa['disp_mesa']}</option>";
                    echo "<option value='Libre'>Libre</option>";
                    echo "<option value='Ocupada'>Ocupada</option>";
                }    
            echo "</select><br>";
            echo "<label for='capacidad_max'>Capacidad Máxima:</label><br>";
            echo "<input type='text' id='capacidad_max' name='capacidad_max' value='{$mesa['capacidad_max']}'><br>";

            if ($dMesa['disp_mesa'] != "Ocupada"){
                echo "<label for='capacidad_mesa'>Capacidad actual:</label><br>";
                echo "<input type='text' id='capacidad_mesa' name='capacidad_mesa' value='{$mesa['capacidad_mesa']}'><br>";
            }
            
            echo "<input class='edit' type='submit' value='Update'>";
            echo "<p id='msg'></p>";

        } else if ($idMantenimiento == 2) {
            $id = $_REQUEST['id_mesa'];
            $query = "SELECT disp_mesa FROM mesas WHERE id_mesa = $id;";
            $sentencia = $pdo->prepare($query);
            $sentencia->execute();
            $dMesa = $sentencia->fetch(PDO::FETCH_ASSOC);
            $dMesa['disp_mesa'];
                if($dMesa['disp_mesa'] == "Libre") {
                    echo "<option value='{$dMesa['disp_mesa']}'>{$dMesa['disp_mesa']}</option>";
                    echo "<option value='Reparacion'>Reparación</option>";
                } else if ($dMesa['disp_mesa'] == "Reparacion") {
                    echo "<option value='{$dMesa['disp_mesa']}'>{$dMesa['disp_mesa']}</option>";
                    echo "<option value='Libre'>Libre</option>";
                }  else {
                    echo "<option value='Ocupada'>Ocupada</option>";
                }  
            echo "</select><br>";
            echo "<label for='capacidad_max'>Capacidad Máxima:</label><br>";
            echo "<input type='text' id='capacidad_max' name='capacidad_max' value='{$mesa['capacidad_max']}'><br>";
            
            echo "<input class='edit' type='submit' value='Update'>";
            echo "<p id='msg'></p>";

        } else {
            $id = $_REQUEST['id_mesa'];
            $query = "SELECT disp_mesa FROM mesas WHERE id_mesa = $id;";
            $sentencia = $pdo->prepare($query);
            $sentencia->execute();
            $dMesa = $sentencia->fetch(PDO::FETCH_ASSOC);
            $dMesa['disp_mesa'];
                if($dMesa['disp_mesa'] == "Libre") {
                    echo "<option value='{$dMesa['disp_mesa']}'>{$dMesa['disp_mesa']}</option>";
                    echo "<option value='Ocupada'>Ocupada</option>";
                    echo "<option value='Reparacion'>Reparación</option>";
                } else if ($dMesa['disp_mesa'] == "Ocupada") {
                    echo "<option value='{$dMesa['disp_mesa']}'>{$dMesa['disp_mesa']}</option>";
                    echo "<option value='Libre'>Libre</option>";
                    echo "<option value='Reparacion'>Reparación</option>";
                } else if ($dMesa['disp_mesa'] == "Reparacion") {
                    echo "<option value='{$dMesa['disp_mesa']}'>{$dMesa['disp_mesa']}</option>";
                    echo "<option value='Libre'>Libre</option>";
                    echo "<option value='Ocupada'>Ocupada</option>";
                }    
            echo "</select><br>";
            echo "<label for='capacidad_max'>Capacidad Máxima:</label><br>";
            echo "<input type='text' id='capacidad_max' name='capacidad_max' value='{$mesa['capacidad_max']}' readonly><br>";

            if ($dMesa['disp_mesa'] != "Ocupada"){
                echo "<label for='capacidad_mesa'>Capacidad actual:</label><br>";
                echo "<input type='text' id='capacidad_mesa' name='capacidad_mesa' value='{$mesa['capacidad_mesa']}'><br>";
            }
            
            echo "<input class='edit' type='submit' value='Update'>";
            echo "<p id='msg'></p>";
        }
        ?>
        </form>
    </div>
</body>
</html>