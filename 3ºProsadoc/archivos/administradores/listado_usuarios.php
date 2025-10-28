<?php
// include_once "sql.php";
include_once "conectar_bbdd.php";
$conn=mysqli_connect($servername, $username, $password, $database);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilo.css">
    <title>Prosadoc</title>
</head>
<body>
    <div class="menu">
    <table>
        <tr>
            <td><img class="imagen_logo_menu" src="../imagenes/logo.png"></td>
        </tr>
        <tr>
            <td><h4><?php echo "$_GET[usuario]"; ?></h4></td>
        </tr>
        <tr>
            <td><a href="administradores/listado_usuarios.php">Listado de incidencias</a></td>
        </tr>
        <tr>
            <td><a href="">Usuarios</a></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td><a href="">Ajustes</a></td>
        </tr>
        <tr>
            <td><a href="../index.php?cerrado">Cerrar Sesión</a></td>
        </tr>
    </table></div>
    </body>
</html>