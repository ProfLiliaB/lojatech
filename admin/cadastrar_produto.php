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
    <<link rel="shortcut icon" href="../img/tech_icon.ico" type="image/x-icon">
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
        ?>
    </header>
    <main>
        <?php
        include_once "../conexao.php";
        $botao = "CADASTRAR";
        $id = $_GET['id'] ?? '';
        $selected = "";
        if($id){
            $botao = "SALVAR";
            $select = $conexao->prepare("SELECT * FROM produto WHERE id_produto = :id");
            $select->bindParam(":id", $id, PDO::PARAM_INT);
            $select->execute();
            if($select->rowCount() > 0){
                $rs = $select->fetch();
                $id_categoria = $rs['id_categoria'];
            }
        }
        ?>
        <div class="conteudo_central">
            <form action="processar_produto.php" method="post" id="form_cadastro">
                <h1>Cadastrar Produto</h1>
                <input type="hidden" name="id" id="id" value="<?=$id?>">
                <div class="form_grupo">
                    <label for="nome">Nome: </label>
                    <input type="text" name="nome" id="nome" class="form_input" value="<?=$rs['nome_produto']??''?>" required>
                </div>
                <div class="form_grupo">
                    <label for="id_categoria">Categoria</label>
                    <select id="id_categoria" name="id_categoria" class="form_input" required>
                        <?php
                        $stmt = $conexao->prepare("SELECT * FROM categoria");
                        $stmt->execute();
                        while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            if($id_categoria === $r['id_categoria']){
                                $selected = "selected";
                            } else { $selected = ""; }
                            echo '<option value="' . $r['id_categoria'] . '" '.$selected.'>' . $r['nome_categoria'] . '</option>';
                        }
                        ?>
                        <option id="add_categoria">ADD +</option>
                    </select>
                </div>
                <div class="form_grupo">
                    <label for="valor">Valor: </label>
                    <input type="number" name="valor" id="valor" class="form_input" step="0.1" value="<?=$rs['valor']??0.0?>" required>
                </div>
                <div class="form_grupo">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" cols="30" rows="10" class="form_input"><?=$rs['descricao_produto']??''?></textarea>
                </div>
                <div class="form_grupo">
                    <label for="estoque">Estoque</label>
                    <input type="number" name="estoque" id="estoque" class="form_input" value="<?=$rs['estoque']??0?>" step="1">
                </div>
                <div class="form_grupo">
                    <button type="submit" class="form_btn"><?=$botao?></button>
                </div>
            </div>
        </form>
    </div>
</main>
<?php
include_once "../footer.php";
?>
<script src="../js/menu.js"></script>
<script src="../js/cadastros.js"></script>
<script>
    const form = document.getElementById("form_cadastro");
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        dados = new FormData(form);
        cadastroGeral(dados, 'processar_produto.php');
        limparFormulario(form);
    });
</script>
</body>

</html>
<?php
// } else {
//     header('location: ../');
// }