<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de imagens com PHP</title>
</head>

<body>
    <h1>Upload de imagens com PHP</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="foto">Foto: </label>
        <input type="file" name="foto[]" multiple id="foto">
        <button type="submit">ENVIAR</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $count = count($_FILES['foto']['name']);
        $i = 0;
        while ($i < $count) {
            echo "<h3>Foto " . $i . "</h3>";
            $tipo = $_FILES['foto']['type'][$i];
            $type = explode('/', $tipo);
            $arquivo[$i] = "upload/foto_" . date('Ymdhis') . "." . $type[1];
            if ($tipo == "image/jpeg" || $tipo == "image/png" || $tipo == "image/jpg") {
                if (move_uploaded_file($_FILES['foto']['tmp_name'][$i], $arquivo[$i])) {
                    echo "<h2>Foto enviada {$i}</h2>";
                }
                echo $arquivo[$i];
                echo "<br>";
                echo $tipo[$i];
            }
            $i++;
        }
    }
    ?>
</body>

</html>
