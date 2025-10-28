<?php 
include_once "../conectar_bbdd.php";
include_once "../sql.php";
$conn=mysqli_connect($servername, $username, $password, $database);
session_start();
// Recogemos las variables
$usuario=$_POST["usuario"];
$usuarioc=$_POST["nombre_usuario"];
$correo=$_POST['correo_usuario'];
$contraseniav=$_POST["password"];
$contrasenian=$_POST["npassword"];
$contrasenian2=$_POST["password2"];
$roll=$_POST["roll"];

$sql="update usuarios set nombre_usuarios='".$usuario."', nombre_completo_usuarios='".$usuarioc."', correo_usuarios='".$correo."', roll='".$roll."' ";
$res=mysqli_query($conn, $sql);

if (isset($contraseniav) && $contraseniav!=""){
	if(comprobar_contrasenia($contraseniav)!=1){
		header("Location: ../administradores.php?ajustes&p");
	}else{
		if (isset($contrasenian) && $contrasenian!="" && isset($contrasenian2) && $contrasenian2!=""){
			if ($contrasenian!=$contrasenian2){
				header("Location: ../administradores.php?ajustes&p2");
			}else{
				$sql.=", contrasenia_usuarios=MD5('".$contrasenian."') ";
			}
		}else{
			header("Location: ../administradores.php?ajustes&p3");
		}
	}
}
$sql.="where ID='".$_SESSION['id_usuario_sesion']."';";
// $res=mysqli_query($conn, $sql);
echo $sql;
//  if ($_SESSION['roll_usuario_actual']=='administrador'){
// header("Location: ../administradores.php?ajustes");
// }else{
// 	header("Location: ../clientes.php?ajustes");	
// }
mysqli_close($conn);
?>