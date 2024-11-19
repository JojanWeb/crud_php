<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="form.php" method="post">
        <label for="nombre">Ingrese nombre:</label>
        <input type="text" name="nombre">

        <button type="submit">Enviar</button>
    </form>
</body>
</html>


<form action="" method="post">
    <style> 
        *{
            box-sizing: border-box;
        }

        .genero__item{
            display: flex;
            flex-direction: column;
        }

        .genero__contenedor{
            width: 100px;
            display: flex;
            justify-content: space-between;
        }
    </style>
    <div>
        <label for="ciudad_id">Ciudad: </label>
        <select name="ciudad_id" id="ciudad_id">
            <?php 
                foreach ($ciudades as $key => $value) {
                    echo $value;
            ?>      <option value="<?= $value['id'] ?>">
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
                    <input type="radio" id="<?= $value['id'] ?>" name="genero" class="genero__input">
                </div>
                
        <?php
            }
        ?>
        </div>
    </div>
</form>