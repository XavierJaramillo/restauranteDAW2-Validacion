<?php
// CONEXIÓN A LA BASE DE DDATOS MEDIANTE PDO
include_once 'config.php';
try {
    $dsn = "mysql:host=".SERVIDOR.";dbname=".BD;
    $pdo = new PDO($dsn, USER, PASSWORD);
    //echo "<script> alert('Conexion establecida')</script>";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo $e->getMessage();
}
?>