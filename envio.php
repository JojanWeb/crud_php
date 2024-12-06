<?php 

session_start();

require('conexion.php');
include('funciones.php');

$conexion = "";
$db = "";

$db = new Conexion();
$conexion = $db->getConexion();

$nombre = $_REQUEST['nombre'] ?? null;
$apellido = $_REQUEST['apellido'] ?? null;
$correo = $_REQUEST['correo'] ?? null;
$fecha = $_REQUEST['fecha'] ?? null;
$genero = $_REQUEST['genero'] ?? null;
$ciudad = $_REQUEST['ciudad_id'] ?? null;
$lenguajes = $_REQUEST['lenguaje'] ?? [];

echo "<pre>";
print_r($_REQUEST);
echo "</pre>";

// $lenguajes = $_REQUEST['lenguaje'];

$errores = validarDatos($nombre, $apellido, $correo, $fecha, $genero);

if (empty($errores)) {
  $sql = "INSERT INTO usuarios (nombre, apellido, correo, fecha_nacimiento, id_genero, id_ciudad) 
          VALUES (:nombre, :apellido, :correo, :fecha_nacimiento, :id_genero, :id_ciudad)";

  echo "CIUDAD: ".$ciudad;
  
  $stm = $conexion->prepare($sql);
  $stm->bindParam(":nombre", $nombre);
  $stm->bindParam(":apellido", $apellido);
  $stm->bindParam(":correo", $correo);
  $stm->bindParam(":fecha_nacimiento", $fecha);
  $stm->bindParam(":id_genero", $genero);
  $stm->bindParam(":id_ciudad", $ciudad);

  $usuarios = $stm->execute();
}else{
  $_SESSION['flash_errors'] = $errores;
  $_SESSION['flash_datos'] = $_REQUEST;
  header('Location: index.php');
  exit;
}

// print_r($lenguajes);
if (empty($errores) && $lenguajes) {
  $ultimo_id = $conexion->lastInsertId();
  
  foreach ($lenguajes as $key => $value) {
      $sql = "INSERT INTO lenguajes_usuarios (id_aprendiz,id_lenguaje) values
      (:id_aprendiz,:id_lenguaje)";
  
      $stm = $conexion->prepare($sql);
  
      $stm->bindParam(":id_aprendiz",$ultimo_id);
      $stm->bindParam(":id_lenguaje",$value);
      $usuarios = $stm->execute();
  }
}

print_r($errores);
header('Location: usuarios.php');