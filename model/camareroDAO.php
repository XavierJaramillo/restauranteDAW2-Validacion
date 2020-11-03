<?php
//MartinezFalconi

//JaramilloVives
class camareroDAO {
    private $pdo;

    public function __construct() {
        include_once '../db/connection.php';
        $this->pdo=$pdo;
    }

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
            session_start();
            $_SESSION['camarero']=$camarero;
            return true;
        } else {
            return false;
        }
    }
}
//FernandezVico

?>