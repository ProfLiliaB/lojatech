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
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        ?>
        <section class="carrossel">
            <div class="imagem-container">
                <img src="img/carrossel.png" alt="Carrossel LojaTech" width="800">
                <div class="legenda">
                    <i class="icofont-duotone icofont-cart icofont-3x"></i>
                    <span>
                        <h1>Bem vindo à LojaTech</h1>
                        <p>Satisfação a cada click</p>
                    </span>
                </div>
            </div>
        </section>
    </header>
    <main>
        <div class="conteudo_central">
            <section id="produtos">
                <!-- Produto 1 -->
                <?php
                include_once "conexao.php";
                $sql = "SELECT p.*, c.* FROM produto p INNER JOIN categoria c ON p.id_categoria = c.id_categoria LIMIT 5";
                $stmt = $conexao->prepare($sql);
                $stmt->execute();
                //loop para exibir todos os registros encontrados    
                while ($array = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_produto = $array['id_produto'];
                    $nome_produto = $array['nome_produto'];
                    $valor_produto = $array['valor'];
                    $nome_categoriaegoria = $array['nome_categoria'];
                    $selectImg = $conexao->prepare("SELECT * FROM imagem WHERE status_imagem = 1 && id_produto = ?");
                    $selectImg->execute([$id_produto]);
                    if ($selectImg->rowCount()) {
                        $imagem = $selectImg->fetch()['nome_imagem'];
                    } else {
                        $imagem = "celularA54.jfif";
                    }
                    echo '
                    <div class="card">
                        <div class="card-header">
                            ' . $nome_produto . '
                        </div>
                        <div class="card-body">
                            <a href="detalhes_produto.php">';
                    echo '<img src="img/' . $imagem . '" width="200" />';
                    echo '</a>
                        </div>
                        <div class="card-footer">
                            <div class="card-valor">R$ ' . number_format($valor_produto, 2, ', ', ' . ') . '</div>
                            <div class="card-oferta">R$ ' . number_format($valor_produto, 2, ', ', ' . ') . '</div>
                            <div class="btn-comprar">
                                <button class="comprar" id="comprar' . $id_produto . '" type="button" value="' . $id_produto . '">Comprar</button>
                            </div>
                            <div class="star">
                                <span>☆</span>
                                <span>☆</span>
                                <span>☆</span>
                                <span>☆</span>
                                <span>☆</span>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </section>
            <div class="btn_listar">
                <a href="lista_produtos.php">Listar Produtos</a>
            </div>
        </div>
    </main>
    <?php
    include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
    <script src="js/add_carrinho.js"></script>
</body>

</html>