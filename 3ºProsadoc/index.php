<?php
//Añadimos los archivos para la conexion de la base de datos y las funciones de la consultas sql
include_once "archivos/conectar_bbdd.php";
include_once "archivos/sql.php";
include_once "archivos/crs.php";
//Iniciamos la $_SESSION
session_start();
//Guardamos el url actual
$host=$_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estilo.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" type="image/jpg" href="imagenes/logo.png"/>

    <title>Prosadoc Incidencias</title>
</head>
<body>
    <!-- Agregamos los iconos svg de iconmonn -->
    <?php iconos(); ?>
    <div class="login">
       <div class="logeo_foto">
            <img class="imagen_logo" src="imagenes/logo.png">
<!-- Comprobamos si el logeo anterior a sido fallido -->
            <?php 
            if (strpos($host, 'error')!==false){
                echo "<p style='color:red;'>Usuario u contraseña incorrecta</p>";
                session_destroy();
            }
//Comprobamos si se cerro sesion
            if (strpos($host, 'cerrado')!==false){
                session_destroy();
            }
//Comprobamos si las variables de sesion tiene el contenido correcto y si no pues nos lleva aqui
            if (strpos($host, 'datos')!==false){
                echo "<p style='color:red;'>Error en la transmision de datos</p>";
                session_destroy();
            }
            ?>
        </div>
<!-- Formulario de inicio sesion -->
        <div class="logeo_formulario">
        <form action="archivos/comprobacion.php" method="post">
            <div class="logeo_formulario_ex"><input type="text" id="usuario" name="usuario" placeholder="Usuario" required class="logeo_formulario_campo"></div>
            <div class="logeo_formulario_ex"><input type="password" id="password" name="password" placeholder="Contraseña" required class="logeo_formulario_campo"></div>
            <div class="logeo_formulario_ex primero"><input type="submit" class="boton"></div>
        </form>
        </div> 
    </div>
<!-- Footer con datos de contacto -->
    <div class="footer">
            <h4 style="display:inline;">Contactanos: </h4>
            <a href="mailto: julian@prosadoc.com">julian@prosadoc.com</a>
            <a href="tel: 625217567">625217567</a>
    </div>
    <script src="js/index.js"></script>
</body>
</html>