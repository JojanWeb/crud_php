<?php
require('conexion.php');

$db = "";
$conexion = "";

$db = new Conexion();
$conexion = $db->getConexion();

$sql = "SELECT * FROM ciudades";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$ciudades = $bandera->fetchAll();


$sql = "SELECT * FROM generos";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$generos = $bandera->fetchAll();

$sql = "SELECT * FROM lenguajes";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$lenguajes = $bandera->fetchAll();

echo "Usuarios";

$sql = "SELECT u.id, u.nombre AS usuario_nombre, u.apellido, u.correo, u.fecha_nacimiento, 
g.nombre AS genero_nombre, c.nombre AS ciudad_nombre
FROM usuarios u INNER JOIN generos g ON u.id_genero = g.id 
INNER JOIN ciudades c ON u.id_ciudad = c.id";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$usuarios = $bandera->fetchAll();



try {
  $mensaje = "";
  $mensaje = $_REQUEST['mensaje'];
  if ($mensaje === 'ELIMINADO EXITOSAMENTE') {
    echo "<script language='javascript'>alert('$mensaje');</script>";
  }
  if ($mensaje === 'ACTUALIZADO EXITOSAMENTE') {
    echo "<script language='javascript'>alert('$mensaje');</script>";
  }
} catch (Exception $e) {
  
}

?>
<style>
    label{
        text-decoration: underline;
        color: blue;
        cursor: pointer;
    }
    .input_editar{
        display: none;
    }
    
    body{
        height: 100vh;
        position: relative;
    }

    .contenedor-editar{
        display: none;
    }

    .input_editar:checked ~ .contenedor-editar{
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100%;
        background: linear-gradient(217deg, rgba(255,0,0,.4), rgba(255,0,0,0) 70.71%),
            linear-gradient(127deg, rgba(0,255,0,.7), rgba(0,255,0,0) 70.71%),
            linear-gradient(336deg, rgba(0,0,255,.8), rgba(0,0,255,0) 70.71%);
    }

    .id{
        display: none;
    }

</style>
<table>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Correo</th>
        <th>Fecha de Nacimiento</th>
        <th>Genero</th>
        <th>Ciudad</th>
    </tr>
    <?php
        foreach ($usuarios as $key => $value) {
    ?>
            <tr>
        <td><?=$value['usuario_nombre']?></td>
        <td><?=$value['apellido']?></td>
        <td><?=$value['correo']?></td>
        <td><?=$value['fecha_nacimiento']?></td>
        <td><?=$value['genero_nombre']?></td>
        <td><?=$value['ciudad_nombre']?></td>
        <td class="relativo">
            <a href="editar.php?id=<?= $value['id']?>">Editar</a>
            <?php echo $value['id']; ?>
            <a href="eliminar.php?id=<?= $value['id']?>">
                Eliminar
            </a>
        </td>
    </tr>
    <?php } ?>
</table>
