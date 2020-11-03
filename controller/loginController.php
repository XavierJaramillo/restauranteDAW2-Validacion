<?php
require_once '../model/camarero.php';
require_once '../model/camareroDAO.php';

if (isset($_POST['user'])) {
    //linea 6 rellena el construct de la clase camarero crea objeto.
    $camarero = new camarero($_POST['user'], md5($_POST['pass']));
    //establece conexion con base de datos y ejecura la query, despues de comprobar la info en camareroDAO.php
    $camareroDAO = new camareroDAO();
    if($camareroDAO->login($camarero)){
        header('Location:../view/zonaRestaurante.php?espacio=Terraza');
    }else {
        header('Location:../view/login.php');
    }
}else {
    header('Location:../view/login.php');
}

?>