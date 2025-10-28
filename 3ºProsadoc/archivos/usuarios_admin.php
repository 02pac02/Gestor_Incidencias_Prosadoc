<?php 
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
    <table>
        <tr>
            <td>Nombre</td>
            <td>Roll</td>
            <td>ID</td>
        </tr>
        <?php
            $filas="select * from usuarios;";
            $numero_filas=mysqli_query($conn, $filas);
            $numero_filas_array=mysqli_fetch_array($numero_filas, MYSQLI_ASSOC);
            $i=1;
            while ($i=10) {
                $i=$i+1;
                echo $i;
            }
            
        ?>
    </table>
</body>
</html>
<?php 
    mysqli_close($conn);
?>