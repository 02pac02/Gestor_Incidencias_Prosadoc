<?php
session_start();
$_SESSION['nnombre']="";
$_SESSION['nfecha']="";
$_SESSION['nroll']="";
$_SESSION['cnumero']="";
header("Location: administradores.php?usuarios");
?>