<?php 
include_once "../conectar_bbdd.php";
$conn=mysqli_connect($servername, $username, $password, $database);
session_start();

$titulo=$_POST["titulo"];
$descripcion=$_POST["descripcion"];

if ($titulo!="" && $descripcion!=""){
	$sql="insert into incidencias (titulo_incidencias, descripcion_incidencias, estado, usuario_incidencias, fecha_creacion_incidencias) values ('".$titulo."', '".$descripcion."', 'sin observar', '".$_SESSION['usuario']."', NOW());";
	$res=mysqli_query($conn, $sql);
	header("Location: ../clientes.php?incidencias");
}


mysqli_close($conn);
?>