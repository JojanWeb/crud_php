<?php

function validarDatos($nombre, $apellido, $correo, $fecha, $genero) {
  $errores = [];

  if (!validarNombre($nombre)) {
    $errores['nombre'] = "¡EL CAMPO NOMBRE NO CUMPLE LOS REQUISITOS!";
  }
  if (!validarNombre($apellido)) {
    $errores['apellido'] = "¡EL CAMPO APELLIDO NO CUMPLE LOS REQUISITOS!";
  }
  if (!validarCorreo($correo)) {
    $errores['correo'] = "¡EL CAMPO EMAIL NO CUMPLE CON LAS CONDICIONES NECESARIAS!";
  }
  if (!validarFecha($fecha)) {
    $errores['fecha'] = "¡LA FECHA DEBE SER COHERENTE!";
  }
  return $errores;
}

function validarNombre($nombre) {
  echo preg_match("/^[A-Za-z]$/", $nombre);
  echo "<br>";
  return preg_match("/^[A-Za-z]$/", $nombre);
}

function validarCorreo($correo) {
  return filter_var($correo, FILTER_VALIDATE_EMAIL);
}

function validarFecha($fecha) {
  echo $fecha;
  return preg_match("/^[\d]{4}-[\d]{2}-[\d]{2}$/", $fecha);
  
}