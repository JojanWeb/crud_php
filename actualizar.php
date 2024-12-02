<?php
require('conexion.php');

$db = new Conexion();
$conexion = $db->getConexion();

echo "<pre>";
print_r($_REQUEST);
echo "<pre>";

$id = $_REQUEST['id_usuario'];
$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$correo = $_REQUEST['correo'];
$fecha = $_REQUEST['fecha'];
$genero = $_REQUEST['genero'];
$ciudad = $_REQUEST['ciudad_id'];
$lenguajes = $_REQUEST['lenguaje'];


$sql = "UPDATE usuarios SET 
nombre = :nombre,
apellido = :apellido,
correo = :correo,
fecha_nacimiento = :fecha_nacimiento,
id_genero = :id_genero,
id_ciudad = :id_ciudad
 WHERE
:id = id";

$stm = $conexion->prepare($sql);

$stm->bindParam(":nombre",$nombre);
$stm->bindParam(":apellido",$apellido);
$stm->bindParam(":correo",$correo);
$stm->bindParam(":fecha_nacimiento",$fecha);
$stm->bindParam(":id_genero",$genero);
$stm->bindParam(":id_ciudad",$ciudad);
$stm->bindParam(":id",$id);
$stm->execute();

foreach ($lenguajes as $key => $value) {
    $sql = "UPDATE lenguajes_usuarios SET
    id_lenguaje = :id_lenguaje
    WHERE $id = id_aprendiz";

    $stm = $conexion->prepare($sql);
    $stm->bindParam(":id_lenguaje",$value);
    $stm->execute();
}

$mensaje = "ACTUALIZADO EXITOSAMENTE";
// echo '<script language="javascript">alert("ACTUALIZADO EXITOSAMENTE");</script>';

header("Location: usuarios.php?mensaje=" . urlencode($mensaje));
