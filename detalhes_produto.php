<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/tech_icon.ico" type="image/x-icon">
    <title>LojaTech Tecnologias</title>
    <link rel="stylesheet" href="icofont/icofont.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/produtos.css">
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        include_once "conexao.php";
        ?>
    </header>
    <main>
        <?php
        $id_produto = $_GET["id_produto"];
        // Consulta do produtos relacionado com a tabela de categorias
        $sql = "SELECT * FROM produto INNER JOIN categoria ON produto.id_cat=categoria.id_cat WHERE id_produto = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$id_produto]);
        // laço para exibição de todos os registros que a query trouxe    
        while ($array = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nome_produto = $array['nome_produto'];
            $descricao_produto = $array['descricao_produto'];
            $valor_produto = $array['valor'];
            $nome_categoria = $array['nome_categoria'];
            $conteudoImagem = $array['imagem'];
            $base64Imagem = base64_encode($conteudoImagem);
        }
        ?>
        <div class="conteudo_central">
            <section id="produtos">
                <div class="fotos">
                    <div class="foto_principal">
                        <?php
                        echo "<img src='data:image/jpeg;base64,{$base64Imagem}' width='280' alt='$nome_categoria'>"
                        ?>
                    </div>
                    <div class="galeria">
                        <img src="img/sansung23.jpeg" width="70" alt="Smartphone">
                        <img src="img/sansung23.jpeg" width="70" alt="Smartphone">
                        <img src="img/sansung23.jpeg" width="70" alt="Smartphone">
                        <img src="img/sansung23.jpeg" width="70" alt="Smartphone">
                    </div>
                </div>
                <div class="container_descricao">
                    <h1><?= $nome_produto ?></h1>
                    <div class="container_detalhes">
                        <div>10% desconto no PIX</div>
                        <div>Parcelamento sem juros</div>
                        <?php
                        $i = 1;
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<div>' . $i . ' X ' . number_format($valor_produto / $i, 2,',','.') . ' s/ juros</div>';
                        }
                        ?>
                    </div>
                    <div class="container_footer">
                        <div class="container_valor">
                            <div class="card-valor">R$ <?php echo number_format($valor_produto, 2, ',', '.') ?>
                            </div>
                            <div class="card-oferta">R$ <?php echo number_format($valor_produto, 2, ',', '.') ?></div>
                        </div>
                        <div class="btn-comprar">
                            <a href="add_carrinho.php?id=<?=$id_produto?>&pg=carrinho">Comprar</a>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <ul class="tabs_menu">
                    <li data-id="#tab1" class="active">Descrição</li>
                    <li data-id="#tab2">Tab 2</li>
                    <li data-id="#tab3">Tab 3</li>
                    <li data-id="#tab4">Tab 4</li>
                </ul>
                <div class="tabs_item active" id="tab1">
                    <div class="tab_conteudo">
                        <?php echo $descricao_produto ?>
                    </div>
                </div>
                <div class="tabs_item" id="tab2">
                    <div class="tab_conteudo">
                        Tab 2
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates in laborum nihil nulla maiores suscipit laboriosam harum quos rem, quidem nemo unde saepe expedita neque aperiam repellat assumenda perspiciatis iusto!
                    </div>
                </div>
                <div class="tabs_item" id="tab3">
                    <div class="tab_conteudo">
                        Tab 3
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates in laborum nihil nulla maiores suscipit laboriosam harum quos rem, quidem nemo unde saepe expedita neque aperiam repellat assumenda perspiciatis iusto!
                    </div>
                </div>
                <div class="tabs_item" id="tab4">
                    <div class="tab_conteudo">
                        Tab 4
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates in laborum nihil nulla maiores suscipit laboriosam harum quos rem, quidem nemo unde saepe expedita neque aperiam repellat assumenda perspiciatis iusto!
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php
    include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
    <script src="js/tabs.js"></script>
</body>

</html>