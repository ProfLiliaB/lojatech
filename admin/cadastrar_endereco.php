<?php
//cadastrar_produto.php
// session_start();
// $status = isset($_SESSION['status']) ? $_SESSION['status']:0;
// if(isset($_SESSION['email']) && $status > 0) {
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
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        include_once "../conexao.php";
        $botao = "CADASTRAR";
        $id = $_GET['id'] ?? '';
        if($id) {
            $botao = "SALVAR";
            $select = $conexao->prepare("SELECT * FROM endereco WHERE id_endereco = :id");
            $select->bindParam(":id", $id, PDO::PARAM_INT);
            $select->execute();
            if($select->rowCount() > 0) {
                $rs = $select->fetch();
            }
        }
        ?>
    </header>
    <main>
        <div class="conteudo_central">            
            <form method="post" id="form_cadastro">
                <h1>Cadastrar Endereco</h1>
                <input type="hidden" name="id" id="id" value="<?=$id?>">
                <div class="form_grupo">
                    <label for="nome">CEP: </label>
                    <input type="text" name="cep" id="cep" class="form_input" value="<?=$rs['cep']??''?>" required>
                </div>
                <div class="form_grupo">
                    <label for="nome">Rua: </label>
                    <input type="text" name="rua" id="rua" class="form_input" value="<?=$rs['rua']??''?>" required>
                </div>
                <div class="form_grupo">
                    <label for="nome">Numero: </label>
                    <input type="text" name="numero" id="numero" class="form_input" value="<?=$rs['n']??''?>" required>
                </div>
                <div class="form_grupo">
                    <label for="nome">Bairro: </label>
                    <input type="text" name="bairro" id="bairro" class="form_input" value="<?=$rs['bairro']??''?>" required>
                </div>
                <div class="form_grupo">
                    <label for="nome">Cidade: </label>
                    <input type="text" name="cidade" id="cidade" class="form_input" value="<?=$rs['cidade']??''?>" required>
                </div>
                <div class="form_grupo">
                    <label for="nome">UF: </label>
                    <input type="text" name="uf" id="uf" class="form_input" value="<?=$rs['uf']??''?>" required>
                </div>
                <div class="form_grupo">
                    <label for="nome">Complemento: </label>
                    <input type="text" name="complemento" id="complemento" class="form_input" value="<?=$rs['complemento']??''?>" maxlength="100">
                </div>
                <div class="form_grupo">
                    <button type="submit" class="form_btn"><?=$botao?></button>
                </div>
            </form>
        </div>
    </main>
    <?php
    include_once "../footer.php";
    ?>
    <script src="../js/menu.js"></script>
    <script src="../js/cadastros.js"></script>
    <script src="../js/endereco.js"></script>
    <script>
        const form = document.getElementById("form_cadastro");
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            dados = new FormData(form);
            cadastroGeral(dados, 'processar_endereco.php');
            limparFormulario(form);
        });
    </script>
</body>

</html>
<?php
// } else {
//     header('location: ../');
// }