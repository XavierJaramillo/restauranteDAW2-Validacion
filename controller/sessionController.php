<?php
require_once '../model/camarero.php';
session_start();
if (!isset($_SESSION['camarero'])) {
    header('Location:../index.php');
}
echo '<h1>Bienvenido '.$_SESSION['camarero']->getNombre_camarero().'</h1><a href="../controller/logoutController.php">Logout</a>';

?>