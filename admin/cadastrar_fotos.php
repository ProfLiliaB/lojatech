<?php
// session_start();
// $status = isset($_SESSION['status']) ? $_SESSION['status'] : 0;
// if (isset($_SESSION['email']) && $status > 0) {
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
    <style>
        .drop-area {
            border: 2px dashed #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #f9f9f9;
        }

        .drop-area.hover {
            border-color: #333;
            background-color: #e8e8e8;
        }

        #preview img {
            max-width: 150px;
            max-height: 150px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        include_once "../conexao.php";
        ?>
    </header>
    <main>
        <div class="conteudo_central">
            <form method="post" id="form_cadastro" enctype="multipart/form-data">
                <h1>Cadasrar Fotos</h1>
                <div class="form_grupo">
                    <label for="produto">Produto: </label>
                    <select name="produto" id="produto" class="form_input">
                        <option value="">Selecione o produto</option>
                        <?php
                        $busca = $conexao->prepare("SELECT * FROM produto");
                        $busca->execute();
                        while ($opt = $busca->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $opt['id_produto'] . '">' . $opt['nome_produto'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- <div class="form_grupo">
                    <input type="file" name="foto" class="form_input">
                </div> -->
                <div class="form_grupo">
                    <label>Arraste as imagens aqui ou clique para selecionar</label>
                    <div id="drop-area" class="drop-area">
                        <input type="file" name="foto[]" id="foto" class="form_input" accept="image/*" hidden>
                        <p>Clique aqui ou arraste as imagens</p>
                    </div>
                    <div id="preview"></div>
                </div>
                <div class="form_grupo">
                    <label for="principal">Foto principal</label>
                    <input type="checkbox" value="1" name="principal" id="principal">
                </div>
                <div class="form_grupo">
                    <button type="submit" class="form_btn">CADASTRAR</button>
                </div>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $principal = $_POST['principal'] ?? 0;
                $id_prod = $_POST['produto'];
                $nome_foto = $_FILES['foto']['name'];
                $info = pathinfo($_FILES['foto']['name']);
                $extensao = $info['extension'];
                if ($extensao == 'jpg' || $extensao == 'png' || $extensao == 'jpeg') {
                    $arquivo = "upload/foto_" . date('Ymdhis') . $id_prod . "." . $extensao;
                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $arquivo)) {
                        $insert = $conexao->prepare("INSERT INTO imagem (nome_imagem, id_produto, status_imagem) VALUES (:nome, :id_prod, :stts)");
                        $insert->bindParam('nome', $arquivo);
                        $insert->bindParam('id_prod', $id_prod);
                        $insert->bindParam('stts', $principal);
                        if ($insert->execute()) {
                            echo '<img src="' . $arquivo . '" alt="Foto do produto" width="300">';
                            echo '<div class="alert-success">Foto cadastrada com sucesso!</div>';
                        } else {
                            echo '<div class="alert-danger">Foto NÃO cadastrada!</div>';
                        }
                    }
                }
            }
            ?>
        </div>
    </main>
    <?php
    include_once "../footer.php";
    ?>
    <script src="../js/menu.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('foto');
            const preview = document.getElementById('preview');

            // Destacar área de drop ao arrastar
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dropArea.classList.add('hover');
                });
            });

            // Remover destaque ao sair
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => dropArea.classList.remove('hover'));
            });

            // Lidando com o drop
            dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                const files = e.dataTransfer.files;
                handleFiles(files);
            });

            // Clique na área para abrir o seletor de arquivos
            dropArea.addEventListener('click', () => fileInput.click());

            // Seleção de arquivo pelo input
            fileInput.addEventListener('change', (e) => handleFiles(e.target.files));

            function handleFiles(files) {
                preview.innerHTML = ''; // Limpa o preview anterior
                [...files].forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            preview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</body>

</html>
<?php
// } else {
//     header('location: ../');
// }
