<?php
//MartinezFalconi
require_once '../model/camarero.php';
session_start();
if (!isset($_SESSION['camarero'])) {
    header('Location:../index.php');
}
echo '<div class="logo"><h2>Bienvenido '.$_SESSION['camarero']->getNombre_camarero().'</h2><h2 style="float: right;"><a href="../controller/logoutController.php">Logout</a></h2></div>';
//JaramilloVives

//FernandezVico

?>