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
        $categoria = $_GET['categoria'] ?? '';
        $nome = $_GET['nome'] ?? '';
        $maiorValor = $_GET['valor_max'] ?? valoMaximo($conexao);
        $menorValor = $_GET['valor_min'] ?? 0;
        $estoque = $_GET['estoque'] ?? '';
        $ordem = $_GET['ordem'] ?? 'p.nome_produto ASC';
        ?>
        <section class="carrossel">
            <div class="container">
                <form method="get" id="form_filtro">
                    <input type="text" id="filtro" name="filtro" placeholder="Pesquisa" value="<?= str_replace('%', '', $nome) ?>">
                    <select id="categoria" name="categoria">
                        <option value="">Todos</option>
                        <?php
                        $select_cat = $conexao->prepare("SELECT * FROM categoria");
                        $select_cat->execute();
                        while ($res = $select_cat->fetch(PDO::FETCH_ASSOC)) {
                            $selected = "";
                            if ($categoria == $res['id_categoria']) {
                                $selected = 'selected';
                            }
                            echo '<option value="' . $res['id_categoria'] . '" ' . $selected . '>' . $res['nome_categoria'] . '</option>';
                        }
                        ?>
                    </select>
                    <select name="ordem" id="ordem">
                        <?php echo '<option value="' . $ordem . '">Ordenar</option>'; ?>
                        <option value="p.nome_produto ASC">Nome</option>
                        <option value="p.valor DESC">Maior Valor</option>
                        <option value="p.valor ASC">Menor Valor</option>
                        <option value="p.id_categoria ASC">Categoria</option>
                    </select>
                    <input type="number" name="estoque" id="estoque" value="<?= $estoque ?>" step="1" style="width:40px;">
                    <span class="range_valor">
                        <input id="valMax" class="range" name="valMax" type="range" min="0" max="<?= valoMaximo($conexao) ?>" value="<?= $maiorValor ?>" step="100" title="Valor" />
                        <span id="valorAtual">Até R$ <?= $maiorValor ?></span>
                    </span>
                    <button type="reset" id="limpar_filtros" class="btn"><i class="fa fa-trash"></i></button>
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
                        <th>Categoria</th>
                        <th>Valor</th>
                        <th>Estoque</th>
                        <th>Fotos</th>
                        <th>Editar</th>
                        <th>Excluir</th>
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
            if (ev.target.classList.contains('range')) {
                document.getElementById('valorAtual').innerText = `Até R$ ${ev.target.value}`
            }
            listarDados();
        });

        function listarDados() {
            fetch('select_produtos.php?pg=' + <?= $pg_atual ?>, {
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