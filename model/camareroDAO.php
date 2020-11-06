<?php
class camareroDAO {
    // ATRIBUTOS
    private $pdo;

    // CONSTRUCTOR
    public function __construct() {
        include_once '../db/connection.php';
        $this->pdo=$pdo;
    }

    // VALIDACIÓN DEL LOGIN
    // DEVUELVE TRUE EN CASO DE QUE EN LA BASE DE DATOS HAYA UN CAMARERO CON NOMBRE Y CONTRASEÑA IGUALES A LA QUE EL
    // USUARIO APORTA EN EL FORMULARIO DEL LOGIN. FALSE, EN CUALQUIER OTRO CASO
    public function login($camarero){
        $query = "SELECT * FROM `camareros` WHERE `nombre_camarero`=? AND `pass_camarero`=?";
        $sentencia=$this->pdo->prepare($query);
        $nombre = $camarero->getNombre_camarero();
        $pass = $camarero->getPass_camarero();
        $sentencia->bindParam(1,$nombre);
        $sentencia->bindParam(2,$pass);
        $sentencia->execute();
        $result=$sentencia->fetch(PDO::FETCH_ASSOC);
        $numRow=$sentencia->rowCount();
        if(!empty($numRow) && $numRow==1){
            $camarero->setId_camarero($result['id_camarero']);
            $camarero->setIdMantenimiento($result['idMantenimiento']);
            session_start();
            $_SESSION['camarero']=$camarero;
            return true;
        } else {
            return false;
        }
    }
}

?>