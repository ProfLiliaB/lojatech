<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/tech_icon.ico" type="image/x-icon">
    <title>LojaTech Tecnologias e mais</title>
    <link rel="stylesheet" href="icofont/icofont.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/produtos.css">
    <link rel="stylesheet" href="css/paginacao.css">
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        include_once "admin/config.php";
        include_once "conexao.php";
        $pg_atual = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
        $maiorValor = valoMaximo($conexao);
        ?>
        <section class="carrossel">
            <div class="container">
                <form method="post" id="form_filtro">
                    <input type="text" id="filtro" name="filtro" placeholder="Pesquisa"
                        value="<?= $_SESSION['param']['filtro'] ?? '' ?>">
                    <select id="categoria" name="categoria">
                        <option value="">Todos</option>
                        <?php
                        $select_cat = $conexao->prepare("SELECT * FROM categoria");
                        $select_cat->execute();
                        while ($res = $select_cat->fetch(PDO::FETCH_ASSOC)) {
                            $selected = "";
                            $filto_cat =  $_SESSION['param']['categoria'] ?? '';
                            if ($filto_cat == $res['id_categoria']) {
                                $selected = 'selected';
                            }
                            echo '<option value="' . $res['id_categoria'] . '" ' . $selected . '>' . $res['nome_categoria'] . '</option>';
                        }
                        ?>
                    </select>
                    <input id="valMax" class="range" name="valMax" type="range" min="0"
                        max="<?=$maiorValor?>" value="<?= $_SESSION['param']['valMax'] ?? $maiorValor ?>" step="100" />
                    <button id="limpar_filtros" class="btn"><i class="fa fa-trash"></i></button>
                </form>
            </div>
        </section>
    </header>
    <main>
        <div class="conteudo_central">
            <span id="list_filtros"></span>
            <div id="lista_produtos"></div>
        </div>
    </main>
    <?php
    include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
    <script src="js/add_carrinho.js"></script>
    <script>
        const list_filtros = document.getElementById('list_filtros')
        const listaProdutos = document.getElementById('lista_produtos')
        listaProdutos.innerHTML = "Carregando...";
        const form_filtro = document.getElementById('form_filtro');
        const dados = document.getElementById('lista_produtos');
        listarDados();
        form_filtro.addEventListener('input', (ev) => {
            ev.preventDefault();
            if(ev.target.classList.contains('range')) {
                ev.target.title = ev.target.value
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

        listaProdutos.addEventListener('click', (e) => {
            if (e.target && e.target.classList.contains('comprar')) { //verifica se existe botões comprar
                const button = e.target;
                adicionarCarrinho(button) //função dentro de add_carrinho.js
            }
        });
    </script>
</body>

</html>