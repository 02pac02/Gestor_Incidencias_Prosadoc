<?php
include_once "conectar_bbdd.php";
include_once "sql.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPmailer/Exception.php';
require 'PHPmailer/PHPMailer.php';
require 'PHPmailer/SMTP.php';

$correo_nuevo=$_POST['correo'];
$mail = new PHPMailer(true);

$_SESSION['correo_nuevo']=$correo_nuevo;

$length=strlen($_SESSION['correo_nuevo']);
$key = "";
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
    $max = strlen($pattern)-1;
for($i = 0; $i < $length; $i++){
    $key .= substr($pattern, mt_rand(0,$max), 1);
}
$_SESSION['clave_gen']=$key;
echo $correo_nuevo;
echo $key;
if (isset($_SESSION['correo_nuevo']) && isset($_SESSION['clave_gen'])){
    nuevo_usuario_temp();
}
if (isset($_SESSION['correo_nuevo'])){
	registro_envio_correo();
}
try {
$mail->SMTPDebug = 0; 
$mail->isSMTP(); 
$mail->Host       = 'mail.prosadoc.com'; 
$mail->SMTPAuth   = true;
$mail->Username   = 'julian@prosadoc.com';
$mail->Password   = 'julian2022'; 
$mail->Port       = 587;

$mail->setFrom('julian@prosadoc.com', 'Prosadoc Incidencias');
$mail->addAddress($correo_nuevo);

$mail->isHTML(true);
$mail->Subject = 'Prosadoc Incidencias';
$mail->Body    = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilo.css">
    <link rel="icon" type="image/jpg" href="../imagenes/logo.png"/>
    <title>Prosadoc Incidencias</title>
</head>
<body>
<img href="http://prosadoc.ddns.net/imagenes/logo.png"></img>
<h4>Hola muy buenas, bienvenido a la nueva aplicacion web de Gestor de incidencias Prosadoc</h4>
<p>Para poder acceder aqui tienes los datos de acceso</p>
<label>Usuario: </label><h5>'.$_SESSION['correo_nuevo'].'</h5>
<label>Contrasenia Temporal: </label><h5>'.$_SESSION['clave_gen'].'</h5>
<a href="https://prosadoc.ddns.net">Pagina de acceso</a>
</body>
</html>
';

$mail->send();
    header("Location: administradores.php?crear_usuarios");
} catch (Exception $e) {
    header("Location: administradores.php?crear_usuarios");
}
?>