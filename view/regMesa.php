<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <title>Historico | Restaurante</title>
    </head>

    <body>
    <?php
    require_once '../controller/sessionController.php';
    include_once '../model/mesaDAO.php';
    echo "<a class='atras' href='./regMesaHorarios.php'>Atrás</a>";
    $id_mesa = $_REQUEST['id_mesa'];

    if(isset($_REQUEST['id_mesa'])) {
        $mesaDAO = new MesaDAO();
        echo "<table>";
        $mesaDAO->viewHistorical();
        echo "</table>";
    }

    ?>
    </body>
</html>