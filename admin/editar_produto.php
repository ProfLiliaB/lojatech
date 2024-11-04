<?php
// editar_produto.php
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
    <link rel="shortcut icon" href="img/tech_icon.ico" type="image/x-icon">
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
        include_once "../menu.php";
        ?>
    </header>
    <main>
        <div class="conteudo_central">
            <?php
          
            // Conexão com o banco de dados - Não copiar o que está em cinza
            include_once "conexao.php";
  

                $id_produto = $_GET['id_produto'];
                $sql = "SELECT * FROM produto where id_produto=$id_produto";
                $stmt = $conexao->prepare($sql);
                $stmt->execute();
                while ($array = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $nome_produto = $array['nome_produto'];
                    $id_categoria_produto = $array['id_cat'];
                    $valor_produto = $array['valor']; 
                    $descricao_produto = $array['descricao_produto'];
                    $conteudoImagem = $array['imagem']; // Conteúdo binário da imagem
                    $base64Imagem = base64_encode($conteudoImagem); // Converter para base64
                }                
            ?>
            <form enctype="multipart/form-data" action="editar_produto_ok.php" method="post" id="form_cadastro">
                <input type="hidden" name="id_produto" id="id_produto"
                    value="<?php echo $id_produto ?>">
                <div class="form_grupo">
                    <label for="nome">Nome: </label>
                    <input type="text" name="nome_produto" id="nome_produto"
                    value="<?php echo $nome_produto ?>" class="form_input">
                </div>
                <div class="form_grupo">
                <label>Categoria</label>
                <select name="id_categoria" id="id_categoria" class="form_input">
                <option value="0">-- Selecione uma Categoria --</option>    
                <?php
                 $con = new PDO("mysql:host=localhost;dbname=lojatechteste", 
                    'root', '');
                    if (!$con) {
                      echo "Problema com conexão";
                     }
                ?>
                <?php  
                $sql = "SELECT * FROM categoria order by nome_cat";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                
                while ($array = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_categoria_categoria = $array['id_cat'];
                    $nome_categoria = $array['nome_cat'];
                ?>
                    <option value="<?php echo("$id_categoria") ?>" 
                    <?=($id_categoria_produto == $id_categoria_categoria)?'selected':''?>>
                    <?php echo("$nome_categoria") ?></option>
                <?php
                }
                ?>
                </select>  

                </div>

                
                <div class="form_grupo">
                    <label for="valor">Valor: </label>
                    <input type="text" name="valor_produto" id="valor_produto"
                    value="<?php echo $valor_produto ?>" class="form_input">
                </div>
                <div class="form_grupo">
                    <label for="descricao"></label>

                    <textarea name="descricao_produto" id="descricao_produto" 
    cols="30" rows="10" class="form_input"><?php echo $descricao_produto; ?></textarea>
                    <center>
                    <br/>
                    <input name="imagem" type="file" />
                    <br/>
                    
                    <?php
                    if ($conteudoImagem != '') {
                    echo "<img src='data:image/jpeg;base64,{$base64Imagem}' width='300px' />";
                    }
                    ?>
                    </center>


       
                <div class="form_grupo">
                    <button type="submit" class="form_btn">ALTERAR</button>
                </div>
                <div class="form_grupo">
                    <?php
                    $msg = $_GET['msg']??"";
                    echo $msg;
                    ?>
                </div>
            </form>
        </div>        
    </main>
    <?php
        include_once "../footer.php";
    ?>
    <script src="../js/menu.js"></script>
</body>

</html>
<?php
// } else {
//     header('location: ../');
// }