<?php
// session_start();
// $status = isset($_SESSION['status']) ? $_SESSION['status']:0;
// if(isset($_SESSION['email']) && $status > 0) {
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/tech_icon.ico" type="image/x-icon">
    <title>LojaTech Tecnologias e mais</title>
    <link rel="stylesheet" href="../icofont/icofont.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/categorias.css">
    <link rel="stylesheet" href="../css/carrinho.css">
    <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <header>
        <?php
        include_once "../menu.php";
        ?>
    </header>
    <main>
        <div class="conteudo_central">
            <?php
            include_once "conexao.php";
            $id_categoria = $_GET['id_categoria'];
            $sql = "SELECT * FROM categoria where id_cat=$id_categoria";
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            while ($array = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $nome_categoria = $array['nome_cat'];
            }
            ?>
            <form action="editar_categoria_ok.php" method="post" id="form_cadastro">
                <input type="hidden" name="id_categoria" id="id_categoria"
                    value="<?php echo $id_categoria ?>">
                <div class="form_grupo">
                    <label for="nome">Nome: </label>
                    <input type="text" name="nome_categoria" id="nome_categoria"
                        value="<?php echo $nome_categoria ?>" class="form_input">
                </div>
                <div class="form_grupo">
                    <button type="submit" class="form_btn">ALTERAR</button>
                </div>
                <div class="form_grupo">
                    <?php
                    $msg = $_GET['msg'] ?? "";
                    echo $msg;
                    ?>
                </div>
            </form>
        </div>
    </main>
    <?php
    include_once "../footer.php";
    ?>
    <script src="../js/menu.js"></script>
</body>

</html>
<?php
// } else {
//     header('location: ../');
// }