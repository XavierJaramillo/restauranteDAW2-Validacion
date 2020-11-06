<?php
// DESTRUIMOS LA SESIÓN Y NOS REDIRIGE A INDEX.PHP
session_start();
session_destroy();
header('Location:../index.php');

?>