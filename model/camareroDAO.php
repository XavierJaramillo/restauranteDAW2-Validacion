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
    public function login($camarero) {
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
            $camarero->setRol($result['rol']);
            $camarero->setEstado($result['estado']);
            session_start();
            $_SESSION['camarero']=$camarero;
            return true;
        } else {
            return false;
        }
    }

    public function getCamarero($id) {
        $query = "SELECT * FROM camareros WHERE id_camarero = ?";
        $sentencia = $this->pdo->prepare($query);
        $sentencia->bindParam(1,$id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    public function readCamareros() {
        $query = "SELECT * FROM camareros;";
        $sentencia=$this->pdo->prepare($query);
        $sentencia->execute();
        $lista_camareros=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($lista_camareros as $camarero) {
            $id=$camarero['id_camarero'];
            echo "<tr>";
            echo "<td style='border:1px solid black'><a class='e' href='../view/modificarCamarero.php?id_camarero=$id'><span class='material-icons'>edit</span></a></th>";
            if($camarero['estado'] == 0) {
                echo "<td style='border:1px solid black'><a class='w' href='../view/index.admin.php?baja=t&id_camarero=$id' OnClick='return confirm(`¿Estás seguro?`);'><span class='material-icons'>work</span></a></th>";
            } else {
                echo "<td style='border:1px solid black'><a class='w' href='../view/index.admin.php?baja=f&id_camarero=$id' OnClick='return confirm(`¿Estás seguro?`);'><span class='material-icons'>work_off</span></a></th>";
            }
            echo "<td style='border:1px solid black'>{$camarero['nombre_camarero']}</th>";
            echo "<td style='border:1px solid black'>{$camarero['pass_camarero']}</th>";
            if($camarero['rol'] == 0) {
                echo "<td style='border:1px solid black'>Camarero</th>";
            } else if ($camarero['rol'] == 1) {
                echo "<td style='border:1px solid black'>Mantenimiento</th>";
            } else {
                echo "<td style='border:1px solid black'>Administrador</th>";
            }
            echo "</tr>";
        }
        return $lista_camareros;
    }

    public function añadir() {
        try {
            // RECOGEMOS LOS DATOS DEL NUEVO camareros
            $nombre=$_POST['nombre_camarero'];
            $pass=md5($_POST['contrasenya']);
            $rol=$_POST['rol'];
            $urlErr = "../view/paginaError.php?accion=añadir&nombre=".$nombre;
        
            // MIRAMOS SI EN LA TABLA NOTAS HAY ALGUNA NOTA CON LA ID DEL camareros
            $query = "INSERT INTO `camareros` (`nombre_camarero`, `pass_camarero`, `rol`) VALUES (?, ?, ?)";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$nombre);
            $sentencia->bindParam(2,$pass);
            $sentencia->bindParam(3,$rol);
            $sentencia->execute();
            
        } catch (Exception $e) {
            echo $e;
            header('Location: '.$urlErr);
        }
    }

    public function bajaCamarero($id, $estado) {
        try {
            //Miramos que el usuario a eliminar no es el propio usuario ni el camarero uno (el cual es fijo y no se puede eliminar)
            if($_SESSION['camarero']->getId_camarero() != $id) {
                $query="UPDATE `camareros` SET `estado` = ? WHERE `id_camarero` = ?";
                $sentencia=$this->pdo->prepare($query);
                $sentencia->bindParam(1,$estado);
                $sentencia->bindParam(2,$id);
                $sentencia->execute();
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function modificarCamarero() {
        try {
            $id = $_POST['id_camarero_modificar'];
            $nombre = $_POST['nombre_camarero'];
            $pass = md5($_POST['contrasenya']);
            $rol = $_POST['rol'];
            $urlErr = "../view/paginaError.php?accion=modificar&nombre=".$nombre;

            $query = "UPDATE camareros SET nombre_camarero=?, pass_camarero=?, rol=? WHERE id_camarero=?";
            $sentencia=$this->pdo->prepare($query);
            $sentencia->bindParam(1,$nombre);
            $sentencia->bindParam(2,$pass);
            $sentencia->bindParam(3,$rol);
            $sentencia->bindParam(4,$id);
            $sentencia->execute();

            header('Location: ../view/index.admin.php');
        } catch (Exception $e) {
            echo $e;
            header('Location: '.$urlErr);
        }
    }
}

?>