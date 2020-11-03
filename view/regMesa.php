<?php
//MartinezFalconi
//JaramilloVives
include_once '../model/mesaDAO.php';

$id_mesa = $_REQUEST['id_mesa'];

if(isset($_REQUEST['id_mesa'])) {
    $mesaDAO = new MesaDAO();
    echo "<table>";
    $mesaDAO->viewHistorical();
    echo "</table>";
}
//FernandezVives

?>