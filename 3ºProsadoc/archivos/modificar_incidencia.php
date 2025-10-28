<?php
include_once "conectar_bbdd.php";
include_once "sql.php";
$conn=mysqli_connect($servername, $username, $password, $database);
session_start();

$titulo=$_POST['titulo'];
$desc=$_POST['desc'];
$id=$_POST['id'];
$estado=$_POST['estado'];

$sql="update incidencias set titulo_incidencias='".$titulo."', descripcion_incidencias='".$desc."', estado='".$estado."' where incidencias_id='".$id."'";
// echo $sql;
$res=mysqli_query($conn, $sql);
if ($_SESSION['roll_usuario_actual']=="administrador"){
header("Location: administradores.php?incidencias");
}else{
header("Location: clientes.php?incidencias");
}
?>