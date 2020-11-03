<html>
<head>
<title>Inicia sesión | Restaurante</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<script src="../js/code.js"></script>
</head>
<body>
<p class="inici">Iniciar</p>
<div class="Registro">
    <div>
        <form class="login" action="../controller/loginController.php" method="POST">
            <p>
            Nombre de usuario: <input type="text" name="user" id="user" ><br>
            Contraseña: <input type="password" name="pass" id="pass" ><br>
            <input type="submit" value="Iniciar sesión">
            </p>
        </form>
    </div>
</body>
</html>