<?php
// include_once "sql.php";
include_once "conectar_bbdd.php";
include_once "sql.php";
include_once "crs.php";
$conn=mysqli_connect($servername, $username, $password, $database);
$host=$_SERVER['REQUEST_URI'];
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php?datos");
}
if (isset($_POST['cnombre'])){
    $_SESSION['cnombre']=$_POST['cnombre'];
}

if (isset($_POST['cfecha'])){
    $_SESSION['cfecha']=$_POST['cfecha'];
}

if (isset($_POST['cestado'])){
    $_SESSION['cestado']=$_POST['cestado'];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilo.css">
    <link rel="stylesheet" href="../icon/style.css">
    <link rel="icon" type="image/jpg" href="../imagenes/logo.png"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Prosadoc Incidencias</title>
</head>
<body>
<?php iconos(); ?>
    <!-- Menu de los clientes -->
    <div class="menu">
        <div class="div-menu"><a href="administradores.php"><img class="imagen_logo_menu" src="../imagenes/logo.png"></a></div>
    <div class="menu-sin">
        <div class="div-menu especial"><h3><?php echo substr($_SESSION['usuario'], 0, 15); ?></h3></div>

<!-- Solo nos deja acceder a este campo si no estamos en incidencias, esto evita el recargo innecesario de la pagina -->
        <div class="div-menu">
            <?php if(strpos($host, "incidencias") || (!strpos($host, "incidencias") && !strpos($host, "crearincidencia") && !strpos($host, "ajustes") && !strpos($host, "visto"))){
                echo "<p><svg class='icon icon-profile'><use xlink:href='#icon-profile'></use></svg> Listado de incidencias</p>";
                }else{
                   echo "<a href='clientes.php?incidencias'><svg class='icon icon-profile'><use xlink:href='#icon-profile'></use></svg> Listado de incidencias</a>"; 
                }
            ?>
        </div>
        <div class="div-menu">
            <?php if(strpos($host, "crearincidencia")){
                echo "<p><svg class='icon icon-plus'><use xlink:href='#icon-plus'></use></svg> Crear Incidencias</p>";
                }else{
                   echo "<a href='clientes.php?crearincidencia'><svg class='icon icon-plus'><use xlink:href='#icon-plus'></use></svg> Crear Incidencias</a>"; 
                }
            ?>
        </div>
        <!-- Solo nos deja acceder a este campo si no estamos en incidencias, esto evita el recargo innecesario de la pagina -->
        <!-- Solo nos deja acceder a este campo si no estamos en incidencias, esto evita el recargo innecesario de la pagina -->
        <div class="div-menu">
            <?php if(strpos($host, "ajustes")){
                echo "<p><svg class='icon icon-cog'><use xlink:href='#icon-cog'></use></svg> Ajustes</p>";
                }else{
                   echo "<a href='clientes.php?ajustes'><svg class='icon icon-cog'><use xlink:href='#icon-cog'></use></svg> Ajustes</a>"; 
                }
            ?>
        </div>
        <div class="div-menu final">  
            <a href="../index.php?cerrado"><svg class="icon icon-switch"><use xlink:href="#icon-switch"></use></svg> Cerrar Sesión</a>
        </div>
    </div>
    </div>
    <!-- Comprobamos que esta en incidencia o si accedio con algun usuario -->
    <!-- Nos muestra las incidencias de todos los usuarios hasta la fecha -->
    <?php if(strpos($host, "incidencias") || (!strpos($host, "crearincidencia") && (!strpos($host, "ajustes") && !strpos($host, "visto")))){ ?>
        <div class="contenido">
            <div class="filtro">
                    <form action="clientes.php?incidencias" method="post">
                        <div class="campo"><input type="text" id="cnombre" name="cnombre" placeholder="Nombre" value="<?php if (isset($_SESSION['cnombre'])){ echo $_SESSION['cnombre'];}?>"></div>
                        <div class="campo"><input type="date" id="cfecha" name="cfecha" value="<?php if (isset($_SESSION['cfecha'])){ echo $_SESSION['cfecha'];}?>"></div>
                        <div class="campo"><select name="cestado" id="cestado">
                            <option value=""<?php if (isset($_SESSION['cestado'])) {if($_SESSION['cestado']==""){echo "selected";}}?>>Estado</option>
                            <option value="sin observar" <?php if (isset($_SESSION['cestado'])) {if($_SESSION['cestado']=="sin observar"){echo "selected";}}?> >Sin observar</option>
                            <option value="en proceso" <?php if (isset($_SESSION['cestado'])) {if($_SESSION['cestado']=="en proceso"){echo "selected";}}?> >En proceso</option>
                            <option value="finalizado" <?php if (isset($_SESSION['cestado'])) {if($_SESSION['cestado']=="finalizado"){echo "selected";}}?> >Finalizado</option>
                        </select></div>
                        <div class="campo"><input class="boton" type="submit"></div>
                    </form>
                    <form action="borrarcampos.php" method="post">
                        <div class="campo"><input type="submit" class="boton" value="Borrar formulario"></input></div>
                    </form>
                    <!-- <svg class='icon icon-loop'><use xlink:href='#icon-loop'></use></svg> -->
            </div>
            <div class="todo">
                <div class="linea inicial"><div class="consulta">titulo</div><div class="consulta disp">f_mod</div><div class="consulta">estado</div><div></div></div>
                <?php 
                    mostrar_incidencias();
                ?>
            </div>
        </div>
    <?php } if(strpos($host, "crearincidencia")){ ?>
        <div class="contenido">
            <h1>Crear Incidencia</h1>
        </div>
        <div class="contenido">
            <form action="clientes/creacion_incidencias.php" method="post">
            <div><label>Titulo de la incidencia: </label><input type="text" id="titulo" name="titulo" required></div>
            <div><label>Descripción de la incidencia: </label><input type="text" id="descripcion" name="descripcion" required></div>
            <div><input type="submit" class="boton"></div>
        </form>
        </div>
    <?php } if(strpos($host, "ajustes")){ ?>
    <div class="contenido">
        <h1>Ajustes</h1>
    </div>
    <?php datos_usuario(); ?>
    <div class="contenido">
        <form action="administradores/ajustes_usuarios.php" method="post">
            <div><label>Nombre de usuario: </label><input type="text" id="usuario" name="usuario" value="<?php echo $_SESSION['usuario']; ?>"></div>
            <div><label>Nombre completo: </label><input type="text" id="usuario" name="nombre_usuario" value="<?php echo $_SESSION['nombrec_usuario_actual']; ?>"></div>
            <div><label>Correo: </label><input type="text" id="usuario" name="correo_usuario" value="<?php echo $_SESSION['correo_usuario_actual']; ?>"></div>
            <div><label>Contraseña Actual: </label><input type="password" id="password" name="password"></div>
            <div><label>Nueva Contraseña: </label><input type="password" id="password" name="npassword"></div>
            <div><label>Repita de la contraseña: </label><input type="password" id="password2" name="password2"></div>
            <!-- <div class=""><input type="submit" class="boton"></div> -->
        </form>
    </div>
    <?php } ?>
    <?php if(strpos($host, "visto") && strpos($host, "see")){ ?>
        <?php datos_incidencias($_GET['id']); ?>
    <?php } if(strpos($host, "visto") && strpos($host, "edit")){ ?>
        <?php editar_incidencias($_GET['id']); ?>
    <?php } ?>
    <div class="footer">
            <h4 style="display:inline;">Contactanos: </h4>
            <a href="mailto: julian@prosadoc.com">julian@prosadoc.com</a>
            <a href="tel: 625217567">625217567</a>
    </div>
<script src="../js/index.js"></script>
<script defer src="../icon/svgxuse.js"></script>
</body>
</html>