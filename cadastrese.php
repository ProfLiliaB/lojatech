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
    <link rel="stylesheet" href="css/carrinho.css">
    <link rel="stylesheet" href="css/form.css">
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
        <div class="conteudo_central">
            <section class="formulario_geral">
                <form method="post" action="processar_cadastro.php" id="form_cadastro">
                    <h1>Cadastre-se</h1>
                    <div class="form_grupo">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" class="form_input">
                    </div>
                    <div class="form_grupo">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form_input">
                    </div>
                    <div class="form_grupo">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form_input">
                    </div>
                    <div class="form_grupo">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" class="form_input">
                    </div>
                    <div class="form_grupo">
                        <button type="submit" class="form_btn">CADASTRAR</button>
                    </div>
                </form>
            </section>
        </div>
        
    </main>
    <?php
        include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
</body>

</html>