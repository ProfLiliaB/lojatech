<nav class="nav" id="nav">
    <a href="./" class="logo"><i class="icofont-micro-chip icofont-2x"></i></a>
    <ul>
        <li>
            <form method="post" action="lista_produtos.php">
                <input type="text" name="nome" id="pesquisa">
                <button type="submit"><i class="icofont icofont-search"></i></button>
            </form>
        </li>
        <li><a href="lista_produtos.php"><i class="icofont-duotone icofont-cube"></i> Produtos</a></li>
        <li></li>
        <li><a href="carrinho.php"><i class="icofont-duotone icofont-cart"></i> Carrinho</a></li>
        <?php
        @session_start();
        if (isset($_SESSION['email'])) {
            echo '<li><a href="minha_conta.php"><i class="fa fa-user"></i> Minha Conta</a></li>
            <li><a href="logout.php"><i class="fa fa-close"></i> Sair</a></li>
            ';
        } else {
            echo '
            <li id="cadastrese"><a href="cadastrese.php"><i class="icofont-duotone icofont-add-users"></i>Cadastre-se</a></li>
            <li id="login"><a href="login.php"><i class="icofont-duotone icofont-unlock"></i> Login</a></li>';
        }
        ?>
    </ul>
    <button id="hamburguer" class="hamburguer"><i class="icofont icofont-navigation-menu"></i></button>
</nav>
<dialog id="avisos">
    <div id="errorMessage"></div>
    <button id="fechar">OK</button>
</dialog>