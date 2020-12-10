<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <h1>Error al reservar la mesa <?php echo $_GET['id'] ?></h1>
</body>
</html>