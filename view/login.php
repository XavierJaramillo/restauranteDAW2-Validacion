<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/login.css">
        <script src="../js/code.js"></script>
        <title>Inicia sesión | Restaurante</title>
    </head>

    <body>
    
    <div class="registro">
        <img class="logoLogin" src="../img/logo.png" alt="Logo restaurante">
        <form class="fLogin" action="../controller/loginController.php" method="POST" onsubmit="return validacionLogin()">
            <p>Usuario: </p>
            <input type="text" name="user" id="user" >
            <p>Contraseña: </p>
            <input type="password" name="pass" id="pass" ><br>
            <?php
                if(isset($_GET['err'])) {
                    if ($_GET['err']==1) {
                        echo "<p style='color:red'>Trabajador inexistente.</p>";
                    } else if ($_GET['err']==2) {
                        echo "<p style='color:red'>Este trabajador esta de baja.</p>";
                    }
                }
            ?>
            <input id="login" type="submit" value="Iniciar sesión">
        </form>
    </div>

    </body>
</html>