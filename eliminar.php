<?php 

require('conexion.php');

$db = new Conexion();
$conexion = $db->getConexion();

$id = $_GET['id'];

$sql = "DELETE FROM lenguajes_usuarios WHERE :id = id_aprendiz";

$stm = $conexion->prepare($sql);
$stm->bindParam(":id",$id);
$usuarios = $stm->execute();

$sql = "DELETE FROM usuarios WHERE :id = id";

$stm = $conexion->prepare($sql);
$stm->bindParam(":id",$id);
$stm->execute();

// echo '<script language="javascript">alert("ELIMINADO EXITOSAMENTE");</script>';
$mensaje = "ELIMINADO EXITOSAMENTE";

header("Location: usuarios.php?mensaje=" . $mensaje);
?>