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
        <?php
        include_once "menu.php";
        include_once "config.php";
        include_once "../conexao.php";
        $pg_atual = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
        ?>
        <section class="carrossel">
            <div class="container">
                <form method="post" id="form_filtro">
                    <input type="text" id="filtro" name="filtro" placeholder="Por nome" value="<?= $_SESSION['param']['filtro'] ?? '' ?>">
                    <input id="valMax" name="valMax" type="range" min="0" max="<?=valoMaximo($conexao)?>" value="<?=$_SESSION['param']['valMax']??valoMaximo($conexao)?>" step="100" />
                    <button id="limpar_filtros" class="btn"><i class="fa fa-trash"></i></button>
                </form>
            </div>
        </section>
    </header>
    <main>
        <div class="conteudo_central">
            <div class="container_btn">
                <a href="cadastrar_produto.php" class="form_btn">Novo Produto</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Status</th>
                        <!-- <th>Editar</th> -->
                    </tr>
                </thead>
                <tbody id="dados">
                </tbody>
            </table>
        </div>
    </main>
    <?php include_once "../footer.php"; ?>
    <script src="../js/menu.js"></script>
    <script>
        const form_filtro = document.getElementById('form_filtro');
        const dados = document.getElementById('dados');
        listarDados();
        form_filtro.addEventListener('input', (ev) => {
            ev.preventDefault();
            listarDados();
        });
        function listarDados() {
            fetch('select_compras.php?pg=' + <?= $pg_atual ?>, {
                    body: new FormData(form_filtro),
                    method: 'POST'
                })
                .then((resposta) => {
                    if (resposta.ok) return resposta.text()
                })
                .then((retorno) => {
                    dados.innerHTML = retorno
                })
                .catch((e) => {
                    console.log(`Mesagem de erro: ${e}`);
                })
        }
    </script>
</body>

</html>
<?php
//} else {
//    header('Location: ../');
//}
?>