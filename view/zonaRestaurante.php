<?php
//MartinezFalconi

//JaramilloVives
include_once '../model/mesaDAO.php';

echo "<a href='../view/zonaRestaurante.php?espacio=VIPs'>HOLA</a>";
echo "<a href='../view/zonaRestaurante.php?espacio=Terraza'>HOLA</a>";
echo "<a href='../view/zonaRestaurante.php?espacio=Comedor'>HOLA</a>";
$mesaDAO = new MesaDAO();
echo "<table id='table'>";
echo $mesaDAO->getMesas();
echo "</table>";

if(isset($_REQUEST['id_mesa'])) {
    echo $mesaDAO->update();
}
//FernandezVives

?>