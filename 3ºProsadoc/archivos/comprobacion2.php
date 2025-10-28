<?php
//Añadimos los archivos para la conexion de la base de datos y las funciones de la consultas sql
include_once "conectar_bbdd.php";
include_once "sql.php";

session_start();
//Nos conectamos a la bbdd
$conn=mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Error en la conexion: " . mysqli_connect_error());
}

$usuario=$_POST["xusuario"];
$nombre=$_POST["xnombre"];
$correo=$_POST["xcorreo"];
$contrasenia=$_POST["xpassword"];
$contrasenia2=$_POST["xpassword2"];

if (!isset($usuario) || !isset($nombre) || !isset($correo) || !isset($contrasenia) || !isset($contrasenia2)){
    die("Error en la recepción de los datos");
}
$_SESSION['usuario']=$usuario;
if ($contrasenia!=$contrasenia2){
    header("Location: acceso.php?error");
}else {
    mod_usuario($usuario, $nombre, $correo, $contrasenia);
    switch (roll_usuario($usuario, $contrasenia)){
            case "administrador":
                header("Location: administradores.php");
                break;
            case "cliente":
                header("Location: clientes.php");
                break;
            default:
                header("Location: ../index.php");
                break;
        }
    
}
mysqli_close($conn);
?>