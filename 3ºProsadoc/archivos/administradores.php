<?php
// include_once "sql.php";
include_once "conectar_bbdd.php";
include_once "sql.php";
include_once "crs.php";
$conn=mysqli_connect($servername, $username, $password, $database);
$host=$_SERVER['REQUEST_URI'];
session_start();
//Comprobamos si las variables de sesion tiene el contenido correcto
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

if (isset($_POST['cnumero'])){
    $_SESSION['cnumero']=$_POST['cnumero'];
}
if (isset($_POST['nnombre'])){
    $_SESSION['nnombre']=$_POST['nnombre'];
}

if (isset($_POST['nfecha'])){
    $_SESSION['nfecha']=$_POST['nfecha'];
}

if (isset($_POST['nroll'])){
    $_SESSION['nroll']=$_POST['nroll'];
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
<!-- Menu principal -->
    <div class="menu">
        <div class="div-menu"><a href="administradores.php"><img class="imagen_logo_menu" src="../imagenes/logo.png"></a></div>
    <div class="menu-sin">
        <div class="div-menu especial"><h3><?php echo substr($_SESSION['usuario'], 0, 15); ?></h3></div>

<!-- Solo nos deja acceder a este campo si no estamos en incidencias, esto evita el recargo innecesario de la pagina -->
        <div class="div-menu">
            <?php if(strpos($host, "incidencias") || (!strpos($host, "incidencias") && !strpos($host, "usuarios") && !strpos($host, "ajustes") && !strpos($host, "visto") && !strpos($host, "ver"))){
                echo "<p><svg class='icon icon-profile'><use xlink:href='#icon-profile'></use></svg> Listado de incidencias</p>";
                }else{
                   echo "<a href='administradores.php?incidencias'><svg class='icon icon-profile'><use xlink:href='#icon-profile'></use></svg> Listado de incidencias</a>"; 
                }
            ?>
        </div>
        <!-- Solo nos deja acceder a este campo si no estamos en incidencias, esto evita el recargo innecesario de la pagina -->
        <div class="div-menu">
            <?php if(strpos($host, "usuarios") && !strpos($host, "crear_usuarios")){
                echo "<p><svg class='icon icon-user'><use xlink:href='#icon-user'></use></svg> Usuarios</p>";
                }else{
                   echo "<a href='administradores.php?usuarios'><svg class='icon icon-user'><use xlink:href='#icon-user'></use></svg> Usuarios</a>"; 
                }
            ?>
        </div>
        <!-- Solo nos deja acceder a este campo si no estamos en incidencias, esto evita el recargo innecesario de la pagina -->
        <div class="div-menu">
            <?php if(strpos($host, "ajustes")){
                echo "<p><svg class='icon icon-cog'><use xlink:href='#icon-cog'></use></svg> Ajustes</p>";
                }else{
                   echo "<a href='administradores.php?ajustes'><svg class='icon icon-cog'><use xlink:href='#icon-cog'></use></svg> Ajustes</a>"; 
                }
            ?>
        </div>
        <div class="div-menu final">  
            <a href="../index.php?cerrado"><svg class="icon icon-switch"><use xlink:href="#icon-switch"></use></svg> Cerrar Sesión</a>
        </div>
    </div>
    </div>
<!-- Solo nos muestra incidencias cuando accedemos y pinchamos en incidencias -->
    <?php if(strpos($host, "incidencias") || (!strpos($host, "incidencias") && !strpos($host, "usuarios") && !strpos($host, "ajustes") && !strpos($host, "visto") && !strpos($host, "ver"))){?>
    <div class="contenido">
        <div class="filtro">
                <form action="administradores.php?incidencias" method="post">
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
            <div class="linea inicial"><div class="consulta">titulo</div><div class="consulta disp">f_mod</div><div class="consulta">estado</div><div class="consulta">creador</div><div></div></div>
            <?php 
                mostrar_incidencias();
            ?>
        </div>
    </div>
<!-- Solo nos muestra usuarios -->
    <?php } if(strpos($host, "usuarios") && !strpos($host, "crear_usuarios")){?>
    <div class="contenido">
        <div class="filtro">
                <form action="administradores.php?usuarios" method="post">
                    <div class="campo"><input type="text" placeholder="Nombre" id="nnombre" name="nnombre" value="<?php if (isset($_SESSION['nnombre'])){ echo $_SESSION['nnombre'];}?>"></div>
                    <div class="campo"><input type="date" placeholder="Ultima sesion" id="nfecha" name="nfecha" value="<?php if (isset($_SESSION['nfecha'])){ echo $_SESSION['nfecha'];}?>"></div>
                    <div class="campo"><select name="nroll" id="nroll">
                        <option value=""<?php if (isset($_SESSION['nroll'])) {if($_SESSION['nroll']==""){echo "selected";}}?>>Tipo de Usuario</option>
                        <option value="administrador" <?php if (isset($_SESSION['nroll'])) {if($_SESSION['nroll']=="administrador"){echo "selected";}}?>>Administrador</option>
                        <option value="root" <?php if (isset($_SESSION['nroll'])) {if($_SESSION['nroll']=="root"){echo "selected";}}?>>Root</option>
                        <option value="cliente" <?php if (isset($_SESSION['nroll'])) {if($_SESSION['nroll']=="cliente"){echo "selected";}}?>>Cliente</option>
                    </select></div>
                    <div class="campo"><input class="boton" type="submit"></div>
                    <div class="campo"><a href="administradores.php?crear_usuarios" class="boton">Crear Usuarios </a></div>
                </form>
                <form action="borrarcampos2.php" method="post">
                    <div class="campo"><input type="submit" class="boton" value="Borrar formulario"></input></div>
                </form>
        </div>
        <div class="todo">
            <div class="linea inicial"><div class="consulta">Nombre</div><div class="consulta disp">Nombre Completo</div><div class="consulta disp">Correo</div><div class="consulta">ROLL</div><div class="consulta disp">Fecha Ultima Sesion</div><div></div></div>
            <?php 
                   mostrar_usuarios(); 
            ?>
        </div>
    </div>
<!-- Solo nos muestra ajustes -->
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
            <div><label>Roll: </label><select name="roll"> 
                <option value="administrador" <?php if ($_SESSION['roll_usuario_actual']=="administrador"){ echo "selected"; } ?> >administrador</option>
                <option value="root" <?php if ($_SESSION['roll_usuario_actual']=="root"){ echo "selected"; } ?> >root</option>
                <option value="cliente" <?php if ($_SESSION['roll_usuario_actual']=="cliente"){ echo "selected"; } ?>>cliente</option>
            </select></div>
            <!-- <div class=""><input type="submit" class="boton"></div> -->
        </form>
    </div>
<!-- Solo nos muestra crear_usuarios -->
<!-- value="<?php echo $_SESSION['usuario']?>"
value="<?php echo $_SESSION['nombrec_usuario_actual']; ?>"
value="<?php echo $_SESSION['correo_usuario_actual']; ?>" -->

    <?php } if(strpos($host, "crear_usuarios")){ ?>
    <div class="contenido">
        <h3>Nuevo Usuario</h3>
        <form action="crear_usuarios.php" method="post">
            <div><label>Correo Electronico: </label><input type="email" id="correo" name="correo" placeholder="Correo Electronico" required ></div>
            <div class=""><input type="submit" class="boton"></div>
        </form>
    </div>
    <?php } if(strpos($host, "visto") && strpos($host, "see")){ ?>
        <?php datos_incidencias($_GET['id']); ?>
    <?php } if(strpos($host, "visto") && strpos($host, "edit")){ ?>
        <?php editar_incidencias($_GET['id']); ?>
    <?php } if(strpos($host, "visto") && strpos($host, "delete")){ ?>
        <?php borrar_incidencias($_GET['id']); ?>
    <?php } if(strpos($host, "ver") && strpos($host, "edit")){ ?>
        <?php datos_usuarios($_GET['id']); ?>
    <?php } if(strpos($host, "ver") && strpos($host, "delete")){ ?>
        <?php borrar_usuarios($_GET['id']); ?>
    <?php } ?>
<script src="../js/index.js"></script>
<script defer src="../icon/svgxuse.js"></script>
</body>
</html>
