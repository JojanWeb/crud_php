<?php 

require('conexion.php');

$db = new Conexion();
$conexion = $db->getConexion();

$id = $_REQUEST['id'];
echo $id;

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
// var_dump($usuario);
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

<div class="formulario-contenedor">
    <h1> FORMULARIO</h1>
    <form action="actualizar.php">
      <input type="hidden" name="id_usuario" value="<?=$id?>">

        <div class="contenedor__label">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?=$usuario['nombre']?>">
        </div>

        <div class="contenedor__label">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" value="<?=$usuario['apellido']?>">
        </div>

        <div class="contenedor__label">
            <label for="correo">Correo</label>
            <input type="text" id="correo" name="correo" value="<?=$usuario['correo']?>">
        </div>

        <div class="contenedor__label">
            <label for="fecha">Fecha de nacimiento</label>
            <input type="date" id="fecha" name="fecha" value="<?=$usuario['fecha_nacimiento']?>">
        </div>

        <div class="contenedor__label">
            <label for="ciudad_id">Ciudad: </label>
            <select name="ciudad_id" id="ciudad_id" name="ciudad">
                <?php 
                    foreach ($ciudades as $key => $value) {
                        echo $value;
                ?>      <option value="<?= $value['id'] ?>" value="<?= $value['id'] ?>" 
                        <?php
                          if ($value['id'] === $usuario['id_ciudad']) {
                            ?> 
                            selected
                        <?php
                          }
                        ?>>
                            <?= $value['nombre'] ?>
                        </option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="genero-contenedor">
            <p>Seleccione su genero:</p>
            <div class="genero">
            <?php 
                foreach ($generos as $key => $value) {
            ?>
                    <div class="genero__contenedor">
                        <label for="<?= $value['id'] ?>" class="genero__label">
                            <?= $value['nombre'] ?>
                        </label>
                        <input type="radio" id="<?= $value['id'] ?>" value="<?= $value['id'] ?>" name="genero" class="genero__input"
                        <?php
                          if ($value['id'] === $usuario['id_genero']) {
                            ?> 
                            checked
                        <?php
                          }
                        ?>>
                    </div>
                    
            <?php
                }
            ?>
            </div>
        </div>

        <div class="lenguajes-contenedor">
            <p>Seleccione sus lenguajes:</p>
            <div class="lenguajes">
            <?php 
                foreach ($lenguajes as $key => $value) {
            ?>
                    <div class="">
                        <label for="<?= $value['id'] ?>" class="genero__label">
                            <?= $value['nombre'] ?>
                        </label>
                        <input type="checkbox" id="<?= $value['id'] ?>" value="<?= $value['id'] ?>" name="lenguaje[]"
                        <?php
                          if (in_array($value['id'], $lenguajes_id)) {
                            ?> 
                            checked
                        <?php
                          }
                        ?>>
                    </div>
                    
            <?php
                }
            ?>
            </div>
        </div>

        <button type="submit">ENVIAR</button>
    </form>
</div>

