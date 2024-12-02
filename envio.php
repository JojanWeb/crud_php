<?php 

$conexion = "";
$db = "";

header('Location: index.php');

echo "<pre>";
print_r($_REQUEST);
echo "</pre>";


require('conexion.php');

$db = new Conexion();
$conexion = $db->getConexion();

$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$correo = $_REQUEST['correo'];
$fecha = $_REQUEST['fecha'];
$genero = $_REQUEST['genero'];
$ciudad = $_REQUEST['ciudad_id'];

$lenguajes = $_REQUEST['lenguaje'];


$sql = "INSERT INTO usuarios (nombre,apellido,correo,fecha_nacimiento,id_genero,id_ciudad) values
(:nombre,:apellido,:correo,:fecha_nacimiento,:id_genero,:id_ciudad)";

$stm = $conexion->prepare($sql);

$stm->bindParam(":nombre",$nombre);
$stm->bindParam(":apellido",$apellido);
$stm->bindParam(":correo",$correo);
$stm->bindParam(":fecha_nacimiento",$fecha);
$stm->bindParam(":id_genero",$genero);
$stm->bindParam(":id_ciudad",$ciudad);
$usuarios = $stm->execute();


$ultimo_id = $conexion->lastInsertId();

foreach ($lenguajes as $key => $value) {
    $sql = "INSERT INTO lenguajes_usuarios (id_aprendiz,id_lenguaje) values
    (:id_aprendiz,:id_lenguaje)";

    $stm = $conexion->prepare($sql);

    $stm->bindParam(":id_aprendiz",$ultimo_id);
    $stm->bindParam(":id_lenguaje",$value);
    $usuarios = $stm->execute();
}
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
    <tr>
        <td><?=$nombre?></td>
        <td><?=$apellido?></td>
        <td><?=$correo?></td>
        <td><?=$fecha?></td>
        <td><?=$genero?></td>
        <td><?=$ciudad?></td>
    </tr>
</table>

<?= header('Location: usuarios.php');