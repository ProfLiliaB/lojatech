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
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/produtos.css">
    <link rel="stylesheet" href="css/carrinho.css">
    <style>
        .btn-comprar {
            padding: .7rem 1rem;
        }
    </style>
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        ?>
    </header>
    <main>
        <center>
            <?php
            $id_usuario = 0;
            if (isset($_SESSION['nome'])) {
                echo "<h2>Bem vindo, você está logado como " . $_SESSION['nome'] . "!</h2>";
                $id_usuario = $_SESSION['id_usuario'];
            } else {
                echo "<h2>Bem vindo visitante!</h2>";
                echo "<h3>Faça o <a href='login.php'>login</a> para uma melhor experiência</h3>";
            }
            ?>
        </center>
        <div class="conteudo_central">
            <section class="carrinho">
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>QTD.</th>
                            <th>Valor Un.</th>
                            <th>Total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once "conexao.php";
                        $totalcarrinho = 0;
                        if (!empty($_SESSION['carrinho'])) {
                            foreach ($_SESSION['carrinho'] as $id_prod => $produto) {
                                $nome_produto = $produto['nome'];
                                $quantidade = $produto['qtd'];
                                $valor = $produto['valor'];
                                $valor_total = $valor * $quantidade;
                                $totalcarrinho = $totalcarrinho + $valor_total;
                                echo "<tr>";
                                echo "<td> $nome_produto </td>";
                                echo "<td> $quantidade </td>";
                                echo "<td>R$ $valor </td>";
                                echo "<td>R$  $valor_total </td>";
                                echo "<td class='acoes'>
                                        <a id='comprar$id_prod' href='add_carrinho.php?id=$id_prod&pg=carrinho'><i class='fa fa-plus'></i></a>
                                        <a id='apagar$id_prod'href='limpa_carrinho.php?id=$id_prod&pg=carrinho'><i class='fa fa-trash'></i></a>
                                    </td>
                                </tr>";
                            }
                            echo '
                                <tr>
                                    <td colspan="5" class="alert-danger">
                                        <a href="limpa_carrinho.php"><i class="fa fa-trash"></i> Limpar</a>
                                    </td>
                                </tr>';
                        } else {
                            echo '
                            <tr>
                                <td colspan="5">Seu carrinho ainda está vazio <i class="fa fa-cart-arrow-down"></i></td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="finalizar">
                    <div class="frete">
                        <form action="" method="post">
                            <div for="frete">Calcula Frete </div>
                            <input type="text" name="frete" id="frete">
                            <button type="submit" class="btn-comprar"> OK </button>
                            <div class="saida_frete">Gratis</div>
                        </form>
                    </div>
                    <div class="desconto_final">Descontos R$ 00,00</div>
                    <div class="total_final">TOTAL A PAGAR R$ <?=$totalcarrinho?></div>
                    <div class="btn-finalizar"><a href="pagto.php"><i class="fa fa-money"></i> Finalizar </a></div>
                </div>
            </section>
        </div>
    </main>
    <?php
    include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
    <script src="js/add_carrinho.js"></script>
</body>

</html>