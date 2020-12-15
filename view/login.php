<html>
    <head>
        <title>Inicia sesión | Restaurante</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <script src="../js/code.js"></script>
    </head>

    <body>
    
    <div class="registro">
        <img class="logoLogin" src="../img/logo.png" alt="Logo restaurante">
        <!-- FORMULARIO CON LOS DOS CAMPOS A RELLENAR (NOMBRE Y CONTRASEÑA), ESTE FORMULARIO SE VALIDA EN LOGINCONTROLLER.PHP -->
        <!-- EL METODO UTILIZADO PARA ENVIAR LOS INPUTS ES POR POST -->
        <form action="../controller/loginController.php" method="POST" onsubmit="return validacionLogin()">
            <p>Nombre de usuario: </p>
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
            <input type="submit" value="Iniciar sesión">
        </form>
    </div>

    </body>
</html>