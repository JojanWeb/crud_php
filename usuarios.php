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

$sql = "SELECT lu.id_aprendiz, u.nombre, u.apellido, l.nombre as nombre_lenguaje FROM lenguajes_usuarios lu
INNER JOIN usuarios u on lu.id_aprendiz = u.id 
INNER JOIN lenguajes l on l.id = lu.id_lenguaje";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$lenguajes_usuarios = $bandera->fetchAll();

// echo "Usuarios";

$sql = "SELECT u.id, u.nombre AS usuario_nombre, u.apellido, u.correo, u.fecha_nacimiento, 
g.nombre AS genero_nombre, c.nombre AS ciudad_nombre
FROM usuarios u INNER JOIN generos g ON u.id_genero = g.id 
INNER JOIN ciudades c ON u.id_ciudad = c.id";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$usuarios = $bandera->fetchAll();

// echo "<pre>";
// print_r($lenguajes_usuarios);
// echo "</pre>";



try {
  if (isset($_REQUEST['mensaje'])) {
      $mensaje = $_REQUEST['mensaje'];
      if ($mensaje === 'ELIMINADO EXITOSAMENTE') {
        echo "<script language='javascript'>alert('$mensaje');</script>";
      }
      if ($mensaje === 'ACTUALIZADO EXITOSAMENTE') {
        echo "<script language='javascript'>alert('$mensaje');</script>";
      } 
  }
} catch (Exception $e) {
  
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuarios</title>
  <link rel="stylesheet" href="css/tabla.css">
</head>
<body>
  <div class="tablas-contenedor">
    <div class="tabla-usuarios">
        <h1 class="titulo titulo--centro">USUARIOS</h1>
        <table class="tabla">
         
    <thead class="tabla__encabezado">
      <tr class="tabla__fila-titulos">
          <th class="tabla__celda-titulos">ID</th>
          <th class="tabla__celda-titulos">Nombre</th>
          <th class="tabla__celda-titulos">Apellido</th>
          <th class="tabla__celda-titulos">Correo</th>
          <th class="tabla__celda-titulos">Fecha de Nacimiento</th>
          <th class="tabla__celda-titulos">Genero</th>
          <th class="tabla__celda-titulos">Ciudad</th>
      </tr>
    </thead>
    <tbody class="tabla_cuerpo">

      <?php
          foreach ($usuarios as $key => $value) {
      ?>
              <tr class="tabla__fila-usuarios">
          <td class="tabla__celda-usuarios tabla__celda-usuarios--negrita"><?=$value['id']?></td>
          <td class="tabla__celda-usuarios"><?=$value['usuario_nombre']?></td>
          <td class="tabla__celda-usuarios"><?=$value['apellido']?></td>
          <td class="tabla__celda-usuarios"><?=$value['correo']?></td>
          <td class="tabla__celda-usuarios"><?=$value['fecha_nacimiento']?></td>
          <td class="tabla__celda-usuarios"><?=$value['genero_nombre']?></td>
          <td class="tabla__celda-usuarios"><?=$value['ciudad_nombre']?></td>
          <td class="tabla__celda-usuarios tabla__celda-usuarios--botones">
              <a class="editar" href="editar.php?id=<?= $value['id']?>">Editar</a>
              <a class="eliminar" href="eliminar.php?id=<?= $value['id']?>">
                  Eliminar
              </a>
          </td>
      </tr>
      
      <?php } ?>
      </tbody>
    </table>
      </div>

    <div class="tabla-lenguajes">
      <h1 class="titulo">LENGUAJES DE LOS USUARIOS</h1>
      <table class="tabla--pequeña">
      <thead class="tabla__encabezado">
        <tr class="tabla__fila-titulos">
            <th class="tabla__celda-titulos">ID</th>
            <th class="tabla__celda-titulos tabla__celda-titulos--centro">Usuario</th>
            <th class="tabla__celda-titulos">Lenguaje</th>
        </tr>
      </thead>
      <tbody class="tabla_cuerpo">

        <?php
            foreach ($lenguajes_usuarios as $key => $value) {
        ?>
                <tr class="tabla__fila-usuarios">
            <td class="tabla__celda-usuarios tabla__celda-usuarios--negrita"><?=$value['id_aprendiz']?></td>
            <td class="tabla__celda-usuarios"><?=$value['nombre']?> <?=$value['apellido']?></td>
            <td class="tabla__celda-usuarios"><?=$value['nombre_lenguaje']?></td>
        </tr>
        
        <?php } ?>
        </tbody>
    </table>
    </div>
  </div>
</body>
</html>
