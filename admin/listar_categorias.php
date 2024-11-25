<?php
//session_start();
//$status = isset($_SESSION['status']) ? $_SESSION['status'] : 0;
//if (isset($_SESSION['email']) && $status > 0) {
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/tech_icon.ico" type="image/x-icon">
    <title>LojaTech Tecnologias e mais</title>
    <link rel="stylesheet" href="../icofont/icofont.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/produtos.css">
    <link rel="stylesheet" href="../css/carrinho.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/paginacao.css">
</head>

<body>
    <header>
        <?php include_once "menu.php"; ?>
    </header>
    <main>
        <div class="conteudo_central">
            <?php
            include_once "../conexao.php";
            ?>
            <div class="container_btn">
                <a href="cadastrar_categoria.php" class="form_btn">Nova Categoria</a>
            </div>            
            <table>
                <thead>
                    <tr>
                        <th>Nome Categoria</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT * FROM categoria";
                $stmt = $conexao->prepare($sql);
                $stmt->execute();
                while ($array = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_categoria = $array['id_categoria'];
                    $nome_categoria = $array['nome_categoria'];
                ?>
                <tr>
                    <td style="width: 70%;text-align: left;"><?php echo $nome_categoria; ?></td>
                    <td>
                        <a href="editar_categoria.php?id=<?php echo $id_categoria ?>" class="form_btn">Editar</a>
                    </td>
                    <td><a href="#" class="form_btn">Excluir</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </main>
    <?php include_once "../footer.php"; ?>
    <script src="../js/menu.js"></script>
</body>

</html>
<?php
//} else {
//    header('Location: ../');
//}
?>