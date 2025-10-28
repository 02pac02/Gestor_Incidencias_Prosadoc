<?php
include_once "conectar_bbdd.php";
include_once "sql.php";
session_start();
?>
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
    <div class="login">
        <div class="formulario">
            <h3>Cambia tus datos personales</h3>
        </div>
        <div class="logeo_formulario">
        <form action="comprobacion2.php" method="post">
            <div class="logeo_formulario_ex"><label>Usuario: </label><input type="text" id="xusuario" name="xusuario" required class="logeo_formulario_campo" value="<?php if (isset($_SESSION['usuario'])){ echo $_SESSION['usuario'];}?>"></div>
            <div class="logeo_formulario_ex"><label>Nombre: </label><input type="text" id="xnombre" name="xnombre" required class="logeo_formulario_campo"></div>
            <div class="logeo_formulario_ex"><label>Correo: </label><input type="email" id="xcorreo" name="xcorreo"  required class="logeo_formulario_campo"></div>
            <?php 
                if (strpos($host, 'error')!==false){
                    echo "<p style='color:red;'>Las contraseñas no coinciden</p>";
                    session_destroy();
                }
            ?>
            <div class="logeo_formulario_ex"><label>Nueva Contraseña: </label><input type="password" id="xpassword" name="xpassword"  required class="logeo_formulario_campo"></div>
            <div class="logeo_formulario_ex"><label>Repita la Contraseña: </label><input type="password" id="xpassword2" name="xpassword2"  required class="logeo_formulario_campo"></div>
            <div class="logeo_formulario_ex primero"><input type="submit" class="boton"></div>
        </form>
        </div> 
    </div>
    <div class="footer">
            <h4 style="display:inline;">Contactanos: </h4>
            <a href="mailto: julian@prosadoc.com">julian@prosadoc.com</a>
            <a href="tel: 625217567">625217567</a>
    </div>
</body>
</html>