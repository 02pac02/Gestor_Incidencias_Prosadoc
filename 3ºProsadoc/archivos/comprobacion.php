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
//Comprobamos si los parametros se han pasado correctamente
$usuario=$_POST["usuario"];
$contrasenia=$_POST["password"];
if (!isset($usuario) || !isset($contrasenia) ){
    die("Error en la recepción de los datos");
}
//Prueba para sql injection

// if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
//     $mysqli->set_charset('utf8');
//     $usuario=$mysqli->real_escape_string($_POST["usuario"]);
//     $contrasenia=$mysqli->real_escape_string($_POST["password"]);
//     if ($nueva_consulta = $mysqli=prepare()){
//         comprobacion_existencia_usuario($usuario, $contrasenia)
//     }
// }

//Guardamos el usuario y la contraseña en la funcion de sesion

$_SESSION['usuario']=$usuario;
$_SESSION['contrasenia']=$contrasenia;

//Llamamos a la funcion que esta en sql.php y comprobamos si el usuario existe

if (comprobacion_existencia_usuario($usuario, $contrasenia)==false){
    header("Location: ../index.php?error");
}else{
//Actualizamos la fecha de las tabala usuarios de inicio de sesion
    actualizar_fecha_sesion_usuario($usuario, $contrasenia);
// Comprobamo si inicio sesion alguna vez para que cambie los datos
    if (comprobar_inicio_sesion_alguna_vez($usuario, $contrasenia)==1){
        header("Location: acceso.php");
    }else{
//Comprobamos el roll de usuario y redirigimos a su lugar
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
}
mysqli_close($conn);
?>