<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <title>Registros | Restaurante</title>
    </head>

    <body>

    <?php
    echo "<a class='atras' href='./zonaRestaurante.php?espacio=Terraza'>Atrás</a>";

    require_once '../controller/sessionController.php';
    include_once '../model/mesaDAO.php';
    echo "<table id='table' class='viewMesas'>";
    $mesaDAO = new MesaDAO();
    echo $mesaDAO->viewMesas();
    echo "</table>";

    ?>
        
    </body>
</html>