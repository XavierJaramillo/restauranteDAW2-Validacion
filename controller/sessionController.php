<?php
// NOS INICIA/SIGUE UNA SESIÓN CON EL OBJETO DE TIPO CAMARERO
require_once '../model/camarero.php';
session_start();

// CONTROLAMOS QUE ESTE INICIALIZADO EL OBJETO CAMARERO DENTRO DE SESSION. DE LO CONTRARIO TE REDIRIGE A INDEX.PHP
// ESTO LO HACEMOS PARA QUE NO PUEDAN DIRIGIRSE DIRECTAMENTE POR URL A LA PAGINA INICIAL, A NO SER QUE SEA LOGGEADO CORRECTAMENTE
if (!isset($_SESSION['camarero'])) {
    header('Location:../index.php');
}

// MENSAJE DE BIENVENIDA Y BOTON LOGOUT
echo '<img class="logo" src="../img/logo.png" alt="Logo restaurante"><h1>Bienvenido '.$_SESSION['camarero']->getNombre_camarero().'</h1><a href="../controller/logoutController.php">Logout</a>';

?>