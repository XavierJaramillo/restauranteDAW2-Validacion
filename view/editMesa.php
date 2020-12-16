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
        <a class='atras' href='./zonaRestaurante.php?tipo_espacio=Terraza'>Atrás</a>
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
        <form action="zonaRestaurante.php" method="POST" class="reservaForm" onsubmit="return validacion()">
        <!-- PONEMOS EL ID DE LA MESA (PERO EN OCULTO PORQUE NO QUEREMOS QUE SEA VISIBLE/EDITABLE) -->
        <input type="text" id="id_mesa" name="id_mesa" style="display:none" value="<?php echo $mesa['id_mesa'];?>">
        
        <label for="nombre_comensal">Nombre comensal:</label><br>
        <input type="text" id="nombre_comensal" name="nombre_comensal" required><br>

        <label for="tipo_espacio">Tipo espacio:</label><br>
        <input type="text" id="tipo_espacio" name="tipo_espacio" value="<?php echo $mesa['tipo_espacio'];?>" readonly><br>

        <label for="dia">Día:</label><br>
        <input type="date" name="dia" id="dia" min="<?php echo date('Y-m-d') ?>"><br>

        <label for="hora">Franja horaria:</label><br>
        <select name="hora" id="hora">
            <option value='13:00h-14:00h'>13:00h-14:00h</option>
            <option value='14:00h-15:00h'>14:00h-15:00h</option>
            <option value='21:00h-22:00h'>21:00h-22:00h</option>
            <option value='22:00h-23:00h'>22:00h-23:00h</option>
        </select><br>
            
        <?php

        $rol = $_SESSION['camarero']->getRol();

        if($rol == 1 || $rol == 2) {
            $id = $_REQUEST['id_mesa'];
            $query = "SELECT disp_mesa FROM mesas WHERE id_mesa = $id;";
            $sentencia = $pdo->prepare($query);
            $sentencia->execute();
            $dMesa = $sentencia->fetch(PDO::FETCH_ASSOC);
            
            echo "<label for='capacidad_max'>Capacidad Máxima:</label><br>";
            echo "<input type='text' id='capacidad_max' name='capacidad_max' value='{$mesa['capacidad_max']}' readonly><br>";

            
            echo "<label for='capacidad_mesa'>Capacidad actual:</label><br>";
            echo "<input type='text' id='capacidad_mesa' name='capacidad_mesa' value='1'><br>";
            
            echo "<input class='edit' type='submit' value='Update'>";
            echo "<p id='msg'></p>";
            echo "<p id='msgHora'></p>";

        } else {
            $id = $_REQUEST['id_mesa'];
            $query = "SELECT disp_mesa FROM mesas WHERE id_mesa = $id;";
            $sentencia = $pdo->prepare($query);
            $sentencia->execute();
            $dMesa = $sentencia->fetch(PDO::FETCH_ASSOC);

            echo "<label for='capacidad_max'>Capacidad Máxima:</label><br>";
            echo "<input type='text' id='capacidad_max' name='capacidad_max' value='{$mesa['capacidad_max']}' readonly><br>";
            
            echo "<label for='capacidad_mesa'>Capacidad actual:</label><br>";
            echo "<input type='text' id='capacidad_mesa' name='capacidad_mesa' value='1'><br>";

            echo "<input class='edit' type='submit' value='Update'>";
            echo "<p id='msg'></p>";
            echo "<p id='msgHora'></p>";

        }
        ?>

        </form>
    </div>
</body>
</html>