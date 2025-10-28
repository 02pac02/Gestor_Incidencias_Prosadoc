<?php
// Añadimos los datos de la base de datos
include_once "conectar_bbdd.php";
// Agregamos la conexion a la base de datos
	$conn=mysqli_connect($servername, $username, $password, $database);
	if (!$conn) {
		die("Error en la conexion: " . mysqli_connect_error());
	}
//Comprueba la existencia del usuario evitando sql injection
function comprobacion_existencia_usuario($usuario, $contrasenia){
	global $conn;
	$sql="select id from usuarios where nombre_usuarios=? and contrasenia_usuarios=?;";
	$stmt=mysqli_prepare($conn,$sql);
	mysqli_stmt_bind_param($stmt, "ss", $usuario, md5($contrasenia));
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $id);
	if (mysqli_stmt_fetch($stmt)) {
		$_SESSION['id_usuario_sesion']=$id;
		return true;
	}else{
		return false;
	}
/*
	$res=mysqli_query($conn, $sql);
	$arr=mysqli_fetch_array($res, MYSQLI_ASSOC);
	foreach ($arr as $clave => $valor) {
			$clave=$valor;
		}
	$_SESSION['id_usuario_sesion']=$valor;
	if (!$arr){ 
		return false;
	}else{ 
		return true;
	}
*/
}
// Actualiza la fecha de ultima sesion de los usuarios
function actualizar_fecha_sesion_usuario($usuario, $contrasenia){
	global $conn;
	$sql="update usuarios set fecha_ultima_sesion=time(NOW()) where nombre_usuarios='".$usuario."' and contrasenia_usuarios=MD5('".$contrasenia."');";
	$res=mysqli_query($conn, $sql);
}
// Recogemos algunos datos de usuario
function datos_usuario(){
	global $conn;
	$sql="select * from usuarios where id='".$_SESSION['id_usuario_sesion']."';";
	$res=mysqli_query($conn, $sql);
	while($mostrar=mysqli_fetch_array($res)){
		$_SESSION['nombrec_usuario_actual']=$mostrar['nombre_completo_usuarios'];
		$_SESSION['correo_usuario_actual']=$mostrar['correo_usuarios'];
	}
}
// Recogemos algunos el roll del usuario actual
function roll_usuario($usuario, $contrasenia){
	global $conn;
	$sql="select roll from usuarios where nombre_usuarios='".$usuario."' and contrasenia_usuarios=MD5('".$contrasenia."');";
	$res=mysqli_query($conn, $sql);
	$arr=mysqli_fetch_array($res, MYSQLI_ASSOC);
		foreach ($arr as $clave => $valor) {
			$roll=$valor;
		}
		$_SESSION['roll_usuario_actual']=$roll;
		return $roll;
	}
// Comprobamos si la contraseña es valida
function comprobar_contrasenia($contraseniav){
	global $conn;
	$sql="select id from usuarios where contrasenia_usuarios=MD5('".$contraseniav."');";
	$res=mysqli_query($conn, $sql);
	$arr=mysqli_fetch_array($res, MYSQLI_ASSOC);
	if (!$arr){ 
		return false;
	}else{ 
		return true;
	}
}
// Mostramos las incidencias con diveo estructurado
function mostrar_incidencias(){ 
		global $conn;
		if ($_SESSION['roll_usuario_actual']!=="administrador"){
			$sql="select * from incidencias where usuario_incidencias='".$_SESSION['usuario']."' and visto='FALSE' ";
			if (isset($_SESSION['cnombre']) && $_SESSION['cnombre']!=""){ 
				$sql.="AND titulo_incidencias like '%".$_SESSION['cnombre']."%' ";
			}
			if (isset($_SESSION['cfecha']) && $_SESSION['cfecha']!=""){ 
				$sql.="AND fecha_creacion_incidencias='".$_SESSION['cfecha']."' ";
			}
			if (isset($_SESSION['cestado']) && $_SESSION['cestado']!=""){ 
				$sql.="AND estado='".$_SESSION['cestado']."' ";
			}
			if (isset($_SESSION['cnumero']) && $_SESSION['cnumero']!=""){ 
				$sql.="AND incidencias_id='".$_SESSION['cnumero']."' ";
			}
			$sql.="ORDER BY fecha_creacion_incidencias desc;";
		}else{
			$sql="select * from incidencias where visto='FALSE' ";
			if (isset($_SESSION['cnombre']) && $_SESSION['cnombre']!=""){ 
				$sql.="AND titulo_incidencias like '%".$_SESSION['cnombre']."%' ";
			}
			if (isset($_SESSION['cfecha']) && $_SESSION['cfecha']!=""){ 
				$sql.="AND fecha_creacion_incidencias='".$_SESSION['cfecha']."' ";
			}
			if (isset($_SESSION['cestado']) && $_SESSION['cestado']!=""){ 
				$sql.="AND estado='".$_SESSION['cestado']."' ";
			}
			if (isset($_SESSION['cnumero']) && $_SESSION['cnumero']!=""){ 
				$sql.="AND incidencias_id='".$_SESSION['cnumero']."' ";
			}
			$sql.="ORDER BY fecha_creacion_incidencias desc;";
		}
	    $result=mysqli_query($conn, $sql);
	        while($mostrar=mysqli_fetch_array($result)){
	            echo "<div class='linea'>";
			            echo "<div class='consulta'>".$mostrar["titulo_incidencias"]."</div>";
			           	echo "<div class='consulta disp'>".$mostrar["fecha_creacion_incidencias"]."</div>";
			            echo "<div class='consulta'>".$mostrar["estado"]."</div>";
			            $_SESSION['id_incidencia']=$mostrar["incidencias_id"];
			            if ($_SESSION['roll_usuario_actual']=="administrador"){
			            	echo "<div class='consulta'>".$mostrar["usuario_incidencias"]."</div>";
			            }
			            echo "<div class='consulta'>";
			            if ($_SESSION['roll_usuario_actual']=='administrador'){
				            echo "<div class='boton-t'><a href='https://prosadoc.ddns.net/archivos/administradores.php?visto&id=". $_SESSION['id_incidencia']."&see'><svg class='icon icon-file-text'><use xlink:href='#icon-file-text'></use></svg></a></div>";
				            echo "<div class='boton-t'><a href='https://prosadoc.ddns.net/archivos/administradores.php?visto&id=". $_SESSION['id_incidencia']."&edit'><svg class='icon icon-pencil'><use xlink:href='#icon-pencil'></use></svg></a></div>";
				            echo "<div class='boton-t'><a href='https://prosadoc.ddns.net/archivos/administradores.php?visto&id=". $_SESSION['id_incidencia']."&delete'><svg class='icon icon-bin'><use xlink:href='#icon-bin'></use></svg></a></div>";
				        	}else{
				        	echo "<div class='boton-t'><a href='https://prosadoc.ddns.net/archivos/clientes.php?visto&id=". $_SESSION['id_incidencia']."&see'><svg class='icon icon-file-text'><use xlink:href='#icon-file-text'></use></svg></a></div>";
				            echo "<div class='boton-t'><a href='https://prosadoc.ddns.net/archivos/clientes.php?visto&id=". $_SESSION['id_incidencia']."&edit'><svg class='icon icon-pencil'><use xlink:href='#icon-pencil'></use></svg></a></div>";
				        	}
			            echo "</div>";
	            echo "</div>";
	        }
		}

// Mostramos los usuarios con diveo estructurado
function mostrar_usuarios(){
	global $conn;
	$sql="select * from usuarios where se_uso='FALSE' ";
	if (isset($_SESSION['nnombre']) && $_SESSION['nnombre']!=""){ 
		$sql.="AND nombre_usuarios like '%".$_SESSION['nnombre']."%' ";
	}
	if (isset($_SESSION['nfecha']) && $_SESSION['nfecha']!=""){ 
		$sql.="AND fecha_creacion_usuarios='".$_SESSION['nfecha']."' ";
	}
	if (isset($_SESSION['nroll']) && $_SESSION['nroll']!=""){ 
		$sql.="AND roll='".$_SESSION['nroll']."' ";
	}
	$sql.="ORDER BY nombre_usuarios asc;";
	$result=mysqli_query($conn, $sql);
	while($mostrar=mysqli_fetch_array($result)){
		echo "<div class='linea'>";
			echo "<div class='consulta'>".substr($mostrar["nombre_usuarios"],0 , 20)."</div>";
			echo "<div class='consulta disp'>".substr($mostrar["nombre_completo_usuarios"],0 , 20)."</div>";
			echo "<div class='consulta disp'>".substr($mostrar["correo_usuarios"],0 , 20)."</div>";
			echo "<div class='consulta'>".$mostrar["roll"]."</div>";
			echo "<div class='consulta disp'>".$mostrar["fecha_ultima_sesion"]."</div>";
			$_SESSION['id_usuarios_m']=$mostrar["ID"];
			echo "<div class='consulta'>";
			echo "<div class='boton-t'><a href='https://prosadoc.ddns.net/archivos/administradores.php?ver&id=".$_SESSION['id_usuarios_m']."&edit'><svg class='icon icon-pencil'><use xlink:href='#icon-pencil'></use></svg></a></div>";
			echo "<div class='boton-t'><a href='https://prosadoc.ddns.net/archivos/administradores.php?ver&id=".$_SESSION['id_usuarios_m']."&delete'><svg class='icon icon-bin'><use xlink:href='#icon-bin'></use></svg></a></div>";  
			echo"</div>";
	    echo "</div>";
	}
}
// Comprobamos si el usuario inicio sesion alguna vez
function comprobar_inicio_sesion_alguna_vez($usuario, $contrasenia){
	global $conn;
	$sql="select sesion_iniciada_usuario from usuarios where nombre_usuarios='".$usuario."' and contrasenia_usuarios=MD5('".$contrasenia."');";
	$res=mysqli_query($conn, $sql);
	$arr=mysqli_fetch_array($res, MYSQLI_ASSOC);
		foreach ($arr as $clave => $valor) {
			$sesion=$valor;
		}
	return $sesion;
}

// Registramos el nuevo correo que hemos enviado
function registro_envio_correo() {
	global $conn;
	$sql="insert into correos_enviados (correo, usuario, fecha) values ('".$_SESSION['correo_nuevo']."', '".$_SESSION['usuario']."', NOW());" ;
	$result=mysqli_query($conn, $sql);
}
// Registramos el nuevo usuario que hemos creado
function nuevo_usuario_temp() {
	global $conn;
	$sql="insert into usuarios (nombre_usuarios, nombre_completo_usuarios, correo_usuarios, contrasenia_usuarios, roll, fecha_creacion_usuarios, sesion_iniciada_usuario) values ('".$_SESSION['correo_nuevo']."', '".$_SESSION['correo_nuevo']."', '".$_SESSION['correo_nuevo']."', md5('".$_SESSION['clave_gen']."'), 'cliente', NOW(), 1)";
	$result=mysqli_query($conn, $sql);
}
// Modificamos los datos de los usuarios
function mod_usuario($usuario, $nombre, $correo, $contrasenia){
	global $conn;
	$sql="update usuarios set nombre_usuarios='".$usuario."', nombre_completo_usuarios='".$nombre."', correo_usuarios='".$correo."', contrasenia_usuarios=md5('".$contrasenia."'), sesion_iniciada_usuario=0 where id='".$_SESSION['id_usuario_sesion']."';";
	$res=mysqli_query($conn, $sql);
}
// Mostramos los datos de las incidencias concretas por id
function datos_incidencias($id){
	global $conn;
	$sql="select titulo_incidencias, descripcion_incidencias, estado, usuario_incidencias, fecha_creacion_incidencias, fecha_modificacion_incidencias from incidencias where incidencias_id='".$id."';";
	$res=mysqli_query($conn, $sql);
	while($mostrar=mysqli_fetch_array($res)){
		$ver="<div class='contenido'>
			<h2>Incidencia Nº ".$id."</h2>";
		if ($mostrar['titulo_incidencias']!=""){
			$ver.="<h3>Titulo de la incidencia: </h3>
			<p>".$mostrar['titulo_incidencias']."</p>";
		}
		if ($mostrar['descripcion_incidencias']!=""){
			$ver.="<h3>Descripción de la incidencia: </h3>
			<p>".$mostrar['descripcion_incidencias']."</p>";
		}
		if ($mostrar['estado']!=""){
			$ver.="<h3>Estado actual de la incidencia: </h3>
			<p>".$mostrar['estado']."</p>";
		}
		if($_SESSION['roll_usuario_actual']=="administrador"){
		if ($mostrar['usuario_incidencias']!=""){
			$ver.="<h3>Usuario que creo la incidencia: </h3>
			<p>".$mostrar['usuario_incidencias']."</p>";
		}
		}
		if ($mostrar['fecha_creacion_incidencias']!=""){
			$ver.="<h3>Fecha de creacion de la incidencia: </h3>
			<p>".$mostrar['fecha_creacion_incidencias']."</p>";
		}
		if ($mostrar['fecha_modificacion_incidencias']!=""){
			$ver.="<h3>Fecha de la ultima modificación de la incidencia: </h3>
			<p>".$mostrar['fecha_modificacion_incidencias']."</p>";
		}
		$ver.="</div>";
		echo $ver;
	}
}
// Editamos los campos de las incidencias
function editar_incidencias($id){
	global $conn;
	$sql="select titulo_incidencias, descripcion_incidencias, estado, usuario_incidencias, fecha_creacion_incidencias, fecha_modificacion_incidencias from incidencias where incidencias_id='".$id."';";
	$res=mysqli_query($conn, $sql);
	while($mostrar=mysqli_fetch_array($res)){
		$ver="<div class='contenido'><h2>Incidencia Nº ".$id."</h2>";
		$ver.="<form action='modificar_incidencia.php' method='post'><div><label>Titulo de la incidencia: </label><input type='text' id='titulo' name='titulo' ";
		if ($mostrar['titulo_incidencias']!=""){
			$ver.="value='".$mostrar['titulo_incidencias']."'></div>";
		}
		$ver.="<div><label>Descripción de la incidencia: </label><input type='text' id='desc' name='desc' ";
		if ($mostrar['descripcion_incidencias']!=""){
			$ver.="value='".$mostrar['descripcion_incidencias']."'></div>";
		}
		$ver.="<div><label>Estado: </label><select name='estado'>";
		$ver.=" <option value='sin observar' ";
		if ($mostrar['estado']=='sin observar'){
			$ver.="selected ";
		}
		$ver.=">Sin observar</option>";
		$ver.=" <option value='en proceso' ";
		if ($mostrar['estado']=='en proceso'){
			$ver.="selected ";
		}
		$ver.=">En proceso</option>";
		$ver.=" <option value='finalizado' ";
		if ($mostrar['estado']=='finalizado'){
			$ver.="selected ";
		}
		$ver.=">Finalizado</option>";
		$ver.="</select></div>";
		$ver.="<div><input type='hidden' name='id' value='".$id."'><input class='boton' type='submit'></div>";
		$ver.="</form></div>";
		echo $ver;
		}
}
// Nos muestra un mensaje para borrar las incidencias
function borrar_incidencias($id){
	$hacer="<script>result=window.confirm('Deseas borrar la incidencia Nº ".$id."'); if (result==true){  }</script>";
	echo $hacer;
}
//Nos muestra un mensaje para borrar los usuarios
function borrar_usuarios($id){
	$hacer="<script>result=window.confirm('Deseas borrar el usuario Nº ".$id."'); if (result==true){  }</script>";
	echo $hacer;
}
// Nos muestra los datos de los usuarios
function datos_usuarios($id){
	global $conn;
	$sql="select nombre_usuarios, nombre_completo_usuarios, correo_usuarios, roll, fecha_creacion_usuarios, fecha_ultima_sesion from usuarios where id='".$id."';";
// 	echo $sql;
	$res=mysqli_query($conn, $sql);
	while($mostrar=mysqli_fetch_array($res)){
		$ver="<div class='contenido'><h2>Usuario Nº ".$id."</h2>";
		$ver.="<form action='modificar_usuario.php' method='post'><div><label>Usuario: </label><input type='text' id='nombre' name='nombre' ";
		if ($mostrar['nombre_usuarios']!=""){
			$ver.="value='".$mostrar['nombre_usuarios']."'></div>";
		}
		$ver.="<div><label>Nombre completo usuario: </label><input type='text' id='nombrec' name='nombrec' ";
		if ($mostrar['nombre_completo_usuarios']!=""){
			$ver.="value='".$mostrar['nombre_completo_usuarios']."'></div>";
		}
		$ver.="<div><label>Correo: </label><input type='text' id='correo' name='correo' ";
		if ($mostrar['correo_usuarios']!=""){
			$ver.="value='".$mostrar['correo_usuarios']."'></div>";
		}
		$ver.="<div><label>Roll: </label><select name='roll'>";
		$ver.=" <option value='administrador' ";
		if ($mostrar['roll']=='administrador'){
			$ver.="selected ";
		}
		$ver.=">administrador</option>";
		$ver.=" <option value='root' ";
		if ($mostrar['roll']=='root'){
			$ver.="selected ";
		}
		$ver.=">Root</option>";
		$ver.=" <option value='cliente' ";
		if ($mostrar['roll']=='cliente'){
			$ver.="selected ";
		}
		$ver.=">Cliente</option>";
		$ver.="</select></div>";
		$ver.="<div><label>Fecha Creación usuario: </label><input type='date' id='fechac' name='fechac' ";
		if ($mostrar['fecha_creacion_usuarios']!=""){
			$ver.="value='".$mostrar['fecha_creacion_usuarios']."'>";
		}
		$ver.="</div><div><label>Ultimo inicio de sesion: </label><input type='date' id='fechaf' name='fechaf' ";
		if ($mostrar['fecha_ultima_sesion']!=""){
			$ver.="value='".$mostrar['fecha_ultima_sesion']."'>";
		}
		$ver.="</div><div><label>Solicitar cambio de contraseña en el proximo inicio de sesion: </label><input type='checkbox' id='cambio' name='cambio'></div>";
		$ver.="<div><input type='hidden' name='id' value='".$id."'></div><div><input class='boton' type='submit'></div>";
		$ver.="</form></div>";
		echo $ver;
		}
}
?>