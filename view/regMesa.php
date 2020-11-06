<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/zonaRestaurante.css">
        <title>Historico | Restaurante</title>
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
    $id_mesa = $_REQUEST['id_mesa'];

    // COMPROBAMOS QUE ESTE INICIALIZADA LA VARIABLE, SI LO ESTÁ, NOS MUESTRA UNA TABLA CON EL HISTORICO DE LA MESA
    // SINO ESTÁ INICIALIZADA, IMPRIME UN MENSAJE DEFAULT
    if(isset($_REQUEST['id_mesa'])) {
        $mesaDAO = new MesaDAO();
        echo "<table id='tableHistorical' style='border-spacing: 55px'>";
        $mesaDAO->viewHistorical();
        echo "</table>";
    }

    ?>
    </body>
</html>