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
            <div class="container">
                <form method="POST">
                    <input type="text" id="nome" name="nome" placeholder="Por nome">
                    <select id="categoria" name="categoria">
                        <option value="">Categoria</option>
                        <?php
                        //Inclui a conexão
                        include_once "conexao.php";
                        $select_cat = $conexao->prepare("SELECT * FROM categoria");
                        $select_cat->execute();
                        while ($res = $select_cat->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $res['id_cat'] . '">' . $res['nome_categoria'] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="text" id="valor_max" name="valor_max" placeholder="Até R$">
                    <button type="submit">Filtrar</button>
                </form>
            </div>
        </section>
    </header>
    <main>
        <div class="conteudo_central">
            <section id="produtos">
                <?php
                include_once "conexao.php";
                $sql = "SELECT * FROM produto p INNER JOIN categoria c ON p.id_cat = c.id_cat";
                //array que conterá todos os parametros selecionados no filtro
                $parametro = [];
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    //verifica se foi usado filtro por categoria
                    if (!empty($_POST['categoria'])) {
                        $sql .= " WHERE c.id_cat = :categoria";
                        $parametro['categoria'] = $_POST['categoria'];
                    }
                    //Filtro por nome
                    if (!empty($_POST['nome'])) {
                        $sql .= " AND p.nome_produto LIKE :nome";
                        $parametro['nome'] = "%" . $_POST['nome'] . "%";
                    }
                    ///filtro por valor máximo
                    if (!empty($_POST['valor_max'])) {
                        $sql .= " AND p.valor <= :valor_max";
                        $parametro['valor_max'] = $_POST['valor_max'];
                    }
                }
                //prepara a consulta sql
                $select = $conexao->prepare($sql);
                //executa a consulta sql
                $select->execute($parametro);
                //loop para exibição de todos os registros  
                while ($prod = $select->fetch()) {
                    $id_produto = $prod['id_produto'];
                    $nome_produto = $prod['nome_produto'];
                    $valor_produto = $prod['valor'];
                    $nome_categoria = $prod['nome_categoria'];
                    $selectImg = $conexao->prepare("SELECT * FROM imagem WHERE status_imagem = 1 && id_produto = ?");
                    $selectImg->execute([$id_produto]);
                    if($selectImg->rowCount()) {
                        $imagem = $selectImg->fetch()['nome_imagem'];
                    } else {
                        $imagem = "celularA54.jfif";
                    }
                    echo '
                    <div class="card">
                        <div class="card-header">
                            '.$nome_produto.'
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
                                <a href="add_carrinho.php?id='.$id_produto.'&pg=lista_produtos">Comprar</a>
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
        </div>
    </main>
    <?php
    include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
</body>

</html>