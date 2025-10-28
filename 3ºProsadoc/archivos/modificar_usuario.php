<?php
include_once "conectar_bbdd.php";
include_once "sql.php";
$conn=mysqli_connect($servername, $username, $password, $database);
session_start();

$nombre=$_POST['nombre'];
$nombrec=$_POST['nombrec'];
$correo=$_POST['correo'];
$roll=$_POST['roll'];
$fechac=$_POST['fechac'];
$fechaf=$_POST['fechaf'];
$id=$_POST['id'];
$cambio=$_POST['cambio'];

$sql="update usuarios set nombre_usuarios='".$nombre."', nombre_completo_usuarios='".$nombrec."', correo_usuarios='".$correo."', roll='".$roll."' ";
if ($cambio="on"){
	$sql.=",sesion_iniciada_usuario=1 ";
}
if ($fechac!=""){
	$sql.=",fecha_creacion_usuarios='".$fechac."' ";
}
if ($fechaf!=""){
	$sql.=",fecha_ultima_sesion='".$fechaf."' ";
}
$sql.="where id='".$id."';";
// echo $sql;
$res=mysqli_query($conn, $sql);

header("Location: administradores.php?usuarios");
?>