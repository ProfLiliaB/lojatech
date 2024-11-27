<nav id="nav">
    <?php session_start();?>
    <a href="./" class="logo"><i class="icofont-micro-chip icofont-2x"></i></a>
    <ul>
        <li></li>
        <li><a href="listar_categorias.php"><i class="icofont-duotone icofont-category"></i> Categorias</a></li>
        <li><a href="listar_produtos.php"><i class="icofont-duotone icofont-cube"></i> Produtos</a></li>
        <li><a href="listar_usuarios.php"><i class="icofont-duotone icofont-users"></i> Clientes</a></li>
        <li><a href="listar_compras.php"><i class="icofont-duotone icofont-cart"></i> Vendas</a></li>
        <li><a href="relatorio_compras.php"><i class="icofont-duotone icofont-chart"></i> Relatório</a></li>
        <li class="menu-not">
            <a href="#" id="abreNotas">
                <i class="icofont-duotone icofont-notification"></i>
                <span class="notificacao" id="notificacao"></span>
            </a>
            <ul class="sub_menu_notas" id="sub_menu_notas">
            </ul>
        </li>
        <?php
        if (isset($_SESSION['email'])) {
            echo '<li><a href="../minha_conta.php"><i class="fa fa-user"></i> Minha Conta</a></li>
            <li><a href="../logout.php"><i class="fa fa-close"></i> Sair</a></li>';
        }
        ?>
    </ul>
    <button id="hamburguer" class="hamburguer"><i class="icofont icofont-navigation-menu"></i></button>
</nav><!-- Fecha NAV -->
<dialog id="avisos">
    <div id="errorMessage"></div>
    <button id="fechar">OK</button>
</dialog>

<script>
    
</script>