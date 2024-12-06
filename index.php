<?php
session_start();

// Recuperar errores y datos flash
$errors = $_SESSION['flash_errors'] ?? [];
$datosUsuario = $_SESSION['flash_datos'] ?? [];

// print_r($errors);
// print_r($datosUsuario);
// echo var_dump($datosUsuario['genero']);


unset($_SESSION['flash_errors'], $_SESSION['flash_datos']);

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

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FORMULARIO</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="contenedor">
    <h1 class="titulo"> FORMULARIO</h1>
    <form action="envio.php" method="post" class="formulario">
        <div class="fomulario__contenedor-inputs">
          <div class="formulario__contenedor-input formulario__contenedor-input--column">
            <label for="nombre" class="formulario__label">Nombre:</label>
            <small class="error"><?= $errors['nombre'] ?? '' ?></small>
            <input type="text" class="formulario__input" id="nombre" name="nombre" required
            value="<?= $datosUsuario['nombre'] ?? '' ?>">
          </div>

          <div class="formulario__contenedor-input formulario__contenedor-input--column">
            <label for="apellido" class="formulario__label">Apellido:</label>
            <small class="error"><?= $errors['apellido'] ?? '' ?></small>
              <input type="text" class="formulario__input" id="apellido" name="apellido" required
              value="<?= $datosUsuario['apellido'] ?? '' ?>">
          </div>
        </div>

        <div class="formulario__contenedor-input formulario__contenedor-input--column">
            <label for="correo" class="formulario__label">Email:</label>
            <small class="error"><?= $errors['correo'] ?? '' ?></small>
            <input type="text" class="formulario__input" id="correo" name="correo" required
            value="<?= $datosUsuario['correo'] ?? '' ?>">
        </div>

        <div class="formulario__contenedor-input">
            <label for="fecha" class="formulario__label formulario__label--margen">Fecha de nacimiento:</label>
            <input type="date" class="formulario__input-fecha" id="fecha" name="fecha" required
            value="<?= $datosUsuario['fecha'] ?? '' ?>">
            <div>
              <small class="error"><?= $errors['fecha'] ?? '' ?></small>
            </div>
          </div>

        <div class="formulario__contenedor-input">
            <label class="formulario__label formulario__label--margen" for="ciudad_id">Ciudad: </label>
            <select class="menu" name="ciudad_id" id="ciudad_id" name="ciudad" required>
                <?php 
                    foreach ($ciudades as $key => $value) {
                ?>      <option class="menu__opcion" value="<?= $value['id'] ?>" value="<?= $value['id'] ?>"
                        <?= !empty($datosUsuario) ? ($datosUsuario['ciudad_id'] == $value['id'] ? "selected" : "") : ""?>>
                            <?= $value['nombre'] ?> 
                        </option>
                <?php
                    }
                ?>
            </select>
        </div>

        <div class="fomulario__contenedor-inputs">
          <div class="lenguajes-contenedor">
              <p class="formulario__label">Lenguajes de Programacion:</p>
              <div class="lenguajes">
              <?php 
                  foreach ($lenguajes as $key => $value) {
              ?>
                      <div class="lenguajes__box">
                        <input type="checkbox" id="<?= $value['id'] ?>" value="<?= $value['id'] ?>" name="lenguaje[]"
                        <?= !empty($datosUsuario['lenguaje']) ? (in_array($value['id'], $datosUsuario['lenguaje']) ? "checked" : "") : "" ?>>
                          <label for="<?= $value['id'] ?>" class="genero__label">
                              <?= $value['nombre'] ?>
                          </label>
                      </div>
                      
              <?php
                  }
              ?>
              </div>
          </div>
          <div class="formulario__contenedor-input formulario__contenedor-input--tamaño">
              <p class="formulario__label">Genero:</p>
              <div class="genero">
              <?php 
                  foreach ($generos as $key => $value) {
              ?>
                      <div class="genero__contenedor">
                        <input type="radio" id="<?= $value['id'] ?>" value="<?= $value['id'] ?>" name="genero" class="genero__input" required
                          <?= !empty($datosUsuario['genero']) ? ($datosUsuario['genero'] == $value['id'] ? "checked" : "") : ""?>>
                        <label class="genero__label" for="<?= $value['id'] ?>" class="genero__label">
                          <?= $value['nombre'] ?>
                        </label>
                      </div>
                      
              <?php
                  }
              ?>
              </div>
          </div>
        </div>

        <button class="boton" type="submit">ENVIAR</button>
    </form>
</div>
</body>
</html>