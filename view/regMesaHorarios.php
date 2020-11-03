<?php
//MartinezFalconi
include_once '../model/mesaDAO.php';
echo "<table>";
$mesaDAO = new MesaDAO();
echo $mesaDAO->viewMesas();
echo "</table>";
//JaramilloVives

//FernandezVives

?>