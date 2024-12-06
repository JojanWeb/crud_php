<?php 


session_start();

// Recuperar errores y datos flash
$errors = $_SESSION['flash_errors'] ?? [];
$datosUsuario = $_SESSION['flash_datos'] ?? [];
unset($_SESSION['flash_errors'], $_SESSION['flash_datos']);
// print_r($errors);
// print_r($datosUsuario);

// echo "<br>";
// echo "CIUDAD".$datosUsuario['ciudad_id'];
// echo "<br>";

require('conexion.php');

$db = new Conexion();
$conexion = $db->getConexion();

if (isset($datosUsuario['id'])) {
  $id = $datosUsuario['id'];
}else{
  $id = $_REQUEST['id'];
}


$sql = "SELECT * FROM generos";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$generos = $bandera->fetchAll();

$sql = "SELECT * FROM ciudades";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$ciudades = $bandera->fetchAll();

$sql = "SELECT * FROM lenguajes";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$lenguajes = $bandera->fetchAll();

$sql = "SELECT * FROM usuarios WHERE id = :id";

$stm = $conexion->prepare($sql);
$stm->bindParam(":id",$id);
$stm->execute();
$usuario = $stm->fetchAll();
$usuario = $usuario[0];
// echo "<pre>";
// print_r($usuario);
// echo "</pre>";

// echo "<pre>";
// var_dump($generos);
// echo "</pre>";

$sql = "SELECT * FROM lenguajes_usuarios WHERE id_aprendiz = :id";

$bandera = $conexion->prepare($sql);
$bandera->bindParam(":id",$id);
$bandera->execute();
$lenguajes_usuario = $bandera->fetchAll();

$lenguajes_id = [];
foreach ($lenguajes_usuario as $key => $value) {
  $lenguajes_id[] = $value['id_lenguaje'];
}

  // echo "<pre>";
  // var_dump($lenguajes_id);
  // echo "</pre>";

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar Usuario</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  
</body>
</html>

<div class="contenedor">
  <h1 class="titulo"> ACTUALIZAR USUARIO</h1>
  <form action="actualizar.php" method="post" class="formulario">
    <input type="hidden" name="id" value="<?=$id?>">
    
    <div class="fomulario__contenedor-inputs">
      <div class="formulario__contenedor-input formulario__contenedor-input--column">
        <label for="nombre" class="formulario__label">Nombre</label>
        <small class="error"><?= $errors['nombre'] ?? '' ?></small>
        <input type="text" class="formulario__input" id="nombre" name="nombre" required value="<?= !empty($datosUsuario['nombre']) ?  $datosUsuario['nombre'] : $usuario['nombre']?>">
      </div>
      
      <div class="formulario__contenedor-input formulario__contenedor-input--column">
        <label for="apellido" class="formulario__label">Apellido</label>
        <small class="error"><?= $errors['apellido'] ?? '' ?></small>
        <input type="text" class="formulario__input" id="apellido" name="apellido" required
        value="<?= !empty($datosUsuario['apellido']) ?  $datosUsuario['apellido'] : $usuario['apellido']?>">
      </div>

    </div>

    
    <div class="formulario__contenedor-input
    formulario__contenedor-input--column">
      <label for="correo" class="formulario__label">Email:</label>
      <small class="error"><?= $errors['correo'] ?? '' ?></small>
      <input type="text" class="formulario__input" id="correo" name="correo" required
      value="<?= !empty($datosUsuario['correo']) ?  $datosUsuario['correo'] : $usuario['correo']?>">
    </div>
    
    <div class="formulario__contenedor-input">
      <label for="fecha" class="formulario__label">Fecha de nacimiento:</label>
      <input type="date" class="formulario__input-fecha" id="fecha" name="fecha" required
      value="<?=!empty($datosUsuario['fecha']) ?  $datosUsuario['fecha'] : $usuario['fecha_nacimiento'] ?>">
      <small class="error"><?= $errors['fecha'] ?? '' ?></small>
    </div>
    
        <div class="formulario__contenedor-input">
            <label class="formulario__label formulario__label--margen" for="ciudad_id">Ciudad: </label>
            <select class="menu" name="ciudad_id" id="ciudad_id" name="ciudad" required>
              <?php 
                    foreach ($ciudades as $key => $value) {
                      ?>
                      <option class="menu__opcion" value="<?= $value['id'] ?>" 
                      <?php
                      if (isset($datosUsuario['ciudad_id']) && $datosUsuario['ciudad_id'] == $value['id']) {
                          echo 'selected';
                      } elseif (isset($usuario['id_ciudad']) && $usuario['id_ciudad'] == $value['id']) {
                          echo 'selected';
                      }
                      ?>>
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
                        
                        <?php
                        if (isset($datosUsuario['lenguaje'])) {
                          if (in_array($value['id'], $datosUsuario['lenguaje'])) {
                            echo 'checked';
                          }
                        }else{
                          if (in_array($value['id'], $lenguajes_id)) {
                            echo 'checked';
                          }
                        }
                        ?>>
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
                        <?= $usuario['id_genero'] === $value['id'] ? 'checked' : "" ?>>
                        <label for="<?= $value['id'] ?>" class="genero__label">
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
      
      <?php
