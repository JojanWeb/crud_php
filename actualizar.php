<?php

session_start();

require('conexion.php');
include('funciones.php');

$db = new Conexion();
$conexion = $db->getConexion();

echo "<pre>";
print_r($_REQUEST);
echo "<pre>";

$id = $_REQUEST['id'];
$nombre = $_REQUEST['nombre'] ?? null;
$apellido = $_REQUEST['apellido'] ?? null;
$correo = $_REQUEST['correo'] ?? null;
$fecha = $_REQUEST['fecha'] ?? null;
$genero = $_REQUEST['genero'] ?? null;
$ciudad = $_REQUEST['ciudad_id'] ?? null;
$lenguajes = $_REQUEST['lenguaje'] ?? [];


$errores = validarDatos($nombre, $apellido, $correo, $fecha, $genero);

if (empty($errores)) {
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
  if (!empty($lenguajes)) {
    $sql = "DELETE FROM lenguajes_usuarios WHERE id_aprendiz = :id_aprendiz";
    $stm = $conexion->prepare($sql);
    $stm->bindParam(":id_aprendiz", $id);
    $stm->execute();

    foreach ($lenguajes as $key => $value) {
      $sql = "INSERT INTO lenguajes_usuarios (id_aprendiz, id_lenguaje) VALUES (:id_aprendiz, :id_lenguaje)";
    
      $stm = $conexion->prepare($sql);
      $stm->bindParam(":id_lenguaje",$value);
      $stm->bindParam(":id_aprendiz", $id);
      $stm->execute();
    }

  }
  $mensaje = "ACTUALIZADO EXITOSAMENTE";
  // echo '<script language="javascript">alert("ACTUALIZADO EXITOSAMENTE");</script>';
  
  header("Location: usuarios.php?mensaje=" . urlencode($mensaje));
  exit;
}else{
  $_SESSION['flash_errors'] = $errores;
  $_SESSION['flash_datos'] = $_REQUEST;
  header('Location: editar.php');
  exit;
}

// print_r($lenguajes);

