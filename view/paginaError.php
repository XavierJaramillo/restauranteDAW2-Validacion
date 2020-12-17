<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/zonaRestaurante.css">
    <title>Error | Restaurante</title>
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
        <form class="filtro" action="./zonaRestaurante.php" method="get">
        <ul>
            <?php
                if($_SESSION['camarero']->getRol() == 2) {
                    echo "<li> <a href='./index.admin.php'>Admin</a> </li>";
                }
            ?>
            
            <li>
                <label for="tipo_espacio">Filtro espacio:</label>
                <select id="tipo_espacio" name="tipo_espacio" style="margin:0;">
                    <?php
                        if($_REQUEST['tipo_espacio'] == "Terraza") {
                            echo "<option value='Terraza'>Terraza</option>";
                            echo "<option value='VIPs'>VIPs</option>";
                            echo "<option value='Comedor'>Comedor</option>";
                        } else if($_REQUEST['tipo_espacio'] == "Comedor") {
                            echo "<option value='Comedor'>Comedor</option>";
                            echo "<option value='Terraza'>Terraza</option>";
                            echo "<option value='VIPs'>VIPs</option>";
                        } else if($_REQUEST['tipo_espacio'] == "VIPs") {
                            echo "<option value='VIPs'>VIPs</option>";
                            echo "<option value='Comedor'>Comedor</option>";
                            echo "<option value='Terraza'>Terraza</option>";
                        }
                    ?>
                </select>
            </li>

            <li>
                <label>Filtro fecha:</label><input type="date" name="filtro_fecha" id="filtro_fecha">
                <input type="submit" value="Enviar">
            </li>
            
        </ul>
    </form>
    </div>
    
    <div class="error">
    <?php

    if(isset($_GET['nombre'])) {
        echo "<span>Error al {$_GET['accion']} usuario. El nombre '{$_GET['nombre']}', ya existe.</span>";
    } else if(isset($_GET['id'])) {
        echo "<span>Error al {$_GET['accion']} la mesa {$_GET['id']}.";
    }
    ?>
    </div>

</body>
</html>