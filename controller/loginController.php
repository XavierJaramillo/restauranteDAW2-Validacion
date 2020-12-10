<?php
require_once '../model/camarero.php';
require_once '../model/camareroDAO.php';

if (isset($_POST['user'])) {
    // INSTANCIAMOS LA CLASE CAMARERO
    $camarero = new camarero($_POST['user'], md5($_POST['pass']));
    // INSTANCIAMOS LA CLASE CAMARERODAO
    $camareroDAO = new camareroDAO();
    // LLAMAMOS AL METODO QUE ENCONTRAMOS EN CAMARERODAO, PARA VALIDAR EL CAMARERO
    if($camareroDAO->login($camarero)){
        // EN CASO DE TRUE NOS REDIRIGE A LA PAGINA PRINCIPAL
        header('Location:../view/zonaRestaurante.php?espacio=Terraza&filtro_fecha=');
    }else {
        // EN CASO DE FALSE NOS REDIRIGE AL LOGIN
        header('Location:../view/login.php');
    }
}else {
    // SI LA VARIABLE USER NO ESTA INICIALIZADA NOS REDIRIGE AL LOGIN
    header('Location:../view/login.php');
}

?>