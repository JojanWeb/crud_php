<?php

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

echo "Usuarios";

$sql = "SELECT u.id, u.nombre AS usuario_nombre, u.apellido, u.correo, u.fecha_nacimiento, g.nombre AS genero_nombre, c.nombre AS ciudad_nombre 
FROM usuarios u INNER JOIN generos g ON u.id_genero = g.id INNER JOIN ciudades c ON u.id_ciudad = c.id";

$bandera = $conexion->prepare($sql);
$bandera->execute();
$usuarios = $bandera->fetchAll();

// echo "<pre>";
// print_r($usuarios);
// echo "</pre>";

?>
<style>
    label{
        text-decoration: underline;
        color: blue;
        cursor: pointer;
    }
    .input_editar{
        display: none;
    }
    
    body{
        height: 100vh;
        position: relative;
    }

    .contenedor-editar{
        display: none;
    }

    .input_editar:checked ~ .contenedor-editar{
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100%;
        background: linear-gradient(217deg, rgba(255,0,0,.4), rgba(255,0,0,0) 70.71%),
            linear-gradient(127deg, rgba(0,255,0,.7), rgba(0,255,0,0) 70.71%),
            linear-gradient(336deg, rgba(0,0,255,.8), rgba(0,0,255,0) 70.71%);
    }

    .id{
        display: none;
    }

</style>
<table>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Correo</th>
        <th>Fecha de Nacimiento</th>
        <th>Genero</th>
        <th>Ciudad</th>
    </tr>
    <?php
        foreach ($usuarios as $key => $value) {
    ?>
            <tr>
        <td><?=$value['usuario_nombre']?></td>
        <td><?=$value['apellido']?></td>
        <td><?=$value['correo']?></td>
        <td><?=$value['fecha_nacimiento']?></td>
        <td><?=$value['genero_nombre']?></td>
        <td><?=$value['ciudad_nombre']?></td>
        <td class="relativo">
            <label for="editar<?= $value['id'] ?>">
                Editar
            </label>
            <?php echo $value['id']; ?>
            <a href="eliminar.php?id=<?= $value['id']?>">
                Eliminar
            </a>
            <input type="checkbox" id="editar<?= $value['id']?>" name="editar" class="input_editar">
            <div class="formulario-contenedor contenedor-editar" >
                <h1> FORMULARIO</h1>
                <form action="actualizar.php">
                    <input type="text" value="<?= $value['id']?>" name="id" class="id">
                    <div class="contenedor__label">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="<?=$value['usuario_nombre']?>">
                    </div>

                    <div class="contenedor__label">
                        <label for="apellido">Apellido</label>
                        <input type="text" id="apellido" name="apellido" value="<?=$value['apellido']?>">
                    </div>

                    <div class="contenedor__label">
                        <label for="correo">Correo</label>
                        <input type="text" id="correo" name="correo" value="<?=$value['correo']?>">
                    </div>

                    <div class="contenedor__label">
                        <label for="fecha">Fecha de nacimiento</label>
                        <input type="date" id="fecha" name="fecha" value="<?=$value['fecha_nacimiento']?>">
                    </div>

                    <div class="contenedor__label">
                        <label for="ciudad_id">Ciudad: </label>
                        <select name="ciudad_id" id="ciudad_id" name="ciudad" value="<?=$value['ciudad_nombre']?>">
                            <?php 
                                foreach ($ciudades as $key => $value) {
                            ?>      <option value="<?= $value['id'] ?>" value="<?= $value['id'] ?>">
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
                            foreach ($generos as $key => $genero) {
                        ?>
                                <div class="genero__contenedor">
                                    <label for="<?= $genero['id'] ?>" class="genero__label">
                                        <?= $genero['nombre'] ?>
                                    </label>
                                    <input type="radio" id="<?= $genero['id'] ?>" value="<?= $genero['id'] ?>" name="genero" class="genero__input">
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
                            foreach ($lenguajes as $key => $lengua) {
                        ?>
                                <div class="">
                                    <label for="<?= $lengua['id'] ?>" class="genero__label">
                                        <?= $lengua['nombre'] ?>
                                    </label>
                                    <input type="checkbox" id="<?= $lengua['id'] ?>" value="<?= $lengua['id'] ?>" name="lenguaje[]"
                                    <?php if ($lengua['id'] === $values['id']) { ?>
                                        checked
                                    ><?php } ?>
                                </div>
                                
                        <?php                                         
                            }
                        ?>
                        </div>
                    </div>

                    <button type="submit">ENVIAR</button>
                </form>
            </div>
        </td>
    </tr>
    <?php } ?>
</table>
