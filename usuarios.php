<?php

echo "Usuarios";

$sql = "SELECT u.nombre AS usuario_nombre, u.apellido, u.correo, u.fecha_nacimiento, g.nombre AS genero_nombre, c.nombre AS ciudad_nombre FROM usuarios u INNER JOIN generos g ON u.id_genero = g.id INNER JOIN ciudades c ON u.id_ciudad = c.id";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$usuarios = $bandera->fetchAll();

echo "<pre>";
print_r($usuarios);
echo "</pre>";

?>

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
        <td><?=$value?></td>
        <td><?=$value?></td>
        <td><?=$value?></td>
        <td><?=$value?></td>
        <td><?=$value?></td>
    </tr>
    <?php } ?>
</table>
