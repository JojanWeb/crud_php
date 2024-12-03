<?php 

$conexion = "";
$db = "";

// header('Location: index.php');

echo "<pre>";
print_r($_REQUEST);
echo "</pre>";


require('conexion.php');

$db = new Conexion();
$conexion = $db->getConexion();

function validarDatos() {
  $errores = array();
  if (isset($_REQUEST)) {
    $nombre = $_REQUEST['nombre'];
    if (!validarNombre($nombre)) {
      array_push($errores, "EL CAMPO NOMBRE NO CUMPLE LOS REQUISITOS");
    }

    $apellido = $_REQUEST['apellido'];

    if (!validarNombre($apellido)) {
      array_push($errores, "EL CAMPO APELLIDO NO CUMPLE LOS REQUISITOS");
    }

    $correo = $_REQUEST['correo'];
    if (!validarCorreo($correo)) {
      array_push($errores, "EL CAMPO EMAIL NO CUMPLE CON LAS CONDICIONES NECESARIAS");
    }

    $fecha = $_REQUEST['fecha'];
    if (!validarFecha($fecha)) {
      array_push($errores, "LA FECHA DEBE SER COHERENTE");
    }
    
    if (!validarGenero()) {
      array_push($errores, "DEBE SELECCIONAR UN GENERO");
    }

    return $errores;
  }
}

function validarNombre($nombre) {
  echo preg_match("/^[A-Z]/", $nombre);
  echo "<br>";
  return preg_match("/^[A-Z]/", $nombre);
}

function validarCorreo($correo) {
  return filter_var($correo, FILTER_VALIDATE_EMAIL);
}

function validarFecha($fecha) {
  echo $fecha;
  return preg_match("/^[\d]{4}-[\d]{2}-[\d]{2}$/", $fecha);
  
}

function validarGenero() {
  if (isset($_REQUEST['genero'])) {
    return true;
  }
  return false;
}

function validarLenguajes() {
  if (isset($_REQUEST['lenguaje'])) {
    $lenguajes = $_REQUEST['lenguaje'];
    return $lenguajes;
  }
  return false;
}


// $lenguajes = $_REQUEST['lenguaje'];

$errores = validarDatos();

echo "ERRORES:".empty($errores);
echo "<br>";

if (!empty($errores)) {
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
}

$lenguajes = validarLenguajes();
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
// header('Location: usuarios.php');