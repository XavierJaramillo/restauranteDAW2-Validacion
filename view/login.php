<html>
    <head>
        <title>Inicia sesión | Restaurante</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <script src="../js/code.js"></script>
    </head>

    <body>
    <p class="Inici">Iniciar</p>
    <div class="Registro">
        <div>
            <form action="../controller/loginController.php" method="POST">
                <p>Nombre de usuario: <input type="text" name="user" id="user" ></p>
                <p>Contraseña: <input type="password" name="pass" id="pass" ></p>
                <input type="submit" value="Iniciar sesión">
            </form>
        </div>
    </body>
</html>