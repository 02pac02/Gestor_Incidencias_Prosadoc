<?php
session_start();
$_SESSION['cnombre']="";
$_SESSION['cfecha']="";
$_SESSION['cestado']="";
$_SESSION['cnumero']="";
if ($_SESSION['roll_usuario_actual']=='administrador'){
header("Location: administradores.php?incidencias");
}else{
header("Location: clientes.php?incidencias");	
}
?>