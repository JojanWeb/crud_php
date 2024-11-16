<?php 

$conexion = "";
$db = "";

require('conexion.php');

$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$correo = $_REQUEST['correo'];
$fecha = $_REQUEST['fecha'];
$genero = $_REQUEST['genero'];

echo $fecha;


$db = new Conexion();
$conexion = $db->getConexion();


$sql = "INSERT INTO usuarios (nombre,apellido,correo,fecha_nacimiento,id_genero,id_ciudad) values
('$nombre','$apellido','$correo','$fecha','1','1')";

$bandera = $conexion->prepare($sql);
$bandera->execute();

?>

<h1>ENVIO REALIZADO CORRECTAMENTE</h1>