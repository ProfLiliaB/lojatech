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
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        ?>
        <dialog id="avisos"></dialog>
    </header>
    <main>
        <div class="conteudo_central">
            <section class="formulario_geral">
                <form action="logar.php" method="post" id="form_login">
                    <h1>Entrar na LojaTech</h1>
                    <input type="hidden" name="status" id="status">
                    <div class="form_grupo">
                        <input type="email" name="email" id="email" class="form_input" placeholder="Email">
                    </div>
                    <div class="form_grupo">
                        <input type="password" name="senha" id="senha" class="form_input" placeholder="Senha">
                    </div>
                    <div class="form_grupo">
                        <button type="submit" class="form_btn">Entrar</button>
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