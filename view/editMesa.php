<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/code.js"></script>
    <title>Editar mesa</title>
</head>
<body>
    <?php
        // require_once '../controller/session.php';
        include_once '../model/mesaDAO.php';
        $mDAO = new MesaDAO();
        $pdo = $mDAO->getPDO();
        $pdo->beginTransaction();
        $id = $_REQUEST['id_mesa'];

        $query = "SELECT * FROM mesas INNER JOIN espacio ON mesas.id_espacio = espacio.id_espacio WHERE id_mesa = $id;";
        $sentencia = $pdo->prepare($query);
        $sentencia->execute();
        $mesa = $sentencia->fetch(PDO::FETCH_ASSOC);
        $pdo->commit();
    ?>
    <div>
        <form action="zonaRestaurante.php" method="POST" onsubmit="return validacionCapacidad()">
        <input type="text" id="id_mesa" name="id_mesa" style="display:none" value="<?php echo $mesa['id_mesa'];?>">
        
        <label for="tipo_espacio">Tipo espacio:</label><br>
        <input type="text" id="tipo_espacio" name="tipo_espacio" value="<?php echo $mesa['tipo_espacio'];?>" readonly><br>

        <label for="disp_mesa">Disponibilidad:</label><br>
        <select name="disp_mesa" id="disp_mesa">
            <?php
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
            ?>
        </select><br>
        
        <label for="capacidad_max">Capacidad máxima:</label><br>
        <input type="text" id="capacidad_max" name="capacidad_max" value="<?php echo $mesa['capacidad_max'];?>" readonly><br>
        
        <label for="capacidad_mesa">Capacidad actual:</label><br>
        <input type="text" id="capacidad_mesa" name="capacidad_mesa" value="<?php echo $mesa['capacidad_mesa'];?>"><br>
        
        <input type="submit" value="Update">
        <p id="msg"></p>
        </form>
    </div>
</body>
</html>


<?php
//MartinezFalconi

//JaramilloVives

//FernandezVives

?>