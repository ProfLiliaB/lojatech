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

    <style>
        /* Define o box-sizing para incluir padding e bordas no tamanho total dos elementos */
        * {
            box-sizing: border-box;
        }

        /* Posiciona o contêiner da imagem (necessário para posicionar as setas esquerda e direita) */
        .container {
            position: relative;
            width: 100%;
        }

        /* Oculta as imagens por padrão */
        .mySlides {
            display: none;
        }
        .mySlides {
            width: 100%;
            height: 250px;
            text-align: center;
        }

        /* Adiciona um cursor de ponteiro ao passar o mouse sobre as imagens em miniatura */
        .cursor {
            cursor: pointer;
        }

        /* Botões de navegação anterior e próximo */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 40%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            border-radius: 0 3px 3px 0;
            user-select: none;
            -webkit-user-select: none;
        }

        /* Posiciona o botão "próximo" à direita */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* Ao passar o mouse, adiciona uma cor de fundo preta com um pouco de transparência */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Texto de numeração (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* Contêiner para o texto da imagem */
        .caption-container {
            text-align: center;
            background-color: #222;
            padding: 2px 16px;
            color: white;
        }

        /* Limpa os elementos flutuantes após as colunas */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Seis colunas lado a lado */
        .column {
            float: left;
            width: 16.66%;
        }

        /* Adiciona um efeito de transparência às imagens em miniatura */
        .demo {
            opacity: 0.6;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }
    </style>
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        include_once "conexao.php";
        ?>
    </header>
    <main>
        <div style="width: 100%;max-width: 450px;margin:auto">
            <div class="container">
                <?php
                $minis = [];
                $id_produto = $_GET["id"]??2;
                $selectImg = $conexao->prepare("SELECT * FROM imagem WHERE id_produto = ?");
                $selectImg->execute([$id_produto]);
                $i = 1;
                $n = $selectImg->rowCount();
                while($imagem = $selectImg->fetch()) {
                    $minis[$i] = $imagem['nome_imagem'];
                    echo '
                    <div class="mySlides">
                        <div class="numbertext">'.$i.' / '.$n.'</div>
                        <img src="upload/' . $imagem['nome_imagem'] . '" style="width:50%">
                    </div>';
                    $i++;
                } 
                ?>
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
                <!-- <div class="caption-container">
                    <p id="caption"></p>
                </div> -->
                <div class="row">
                    <?php
                    foreach($minis as $k => $img) {
                        echo '
                        <div class="column">
                            <img class="demo cursor" src="upload/' . $img. '" style="width:50%" onclick="currentSlide('.$k.')" alt="Imagem '.$k.'">
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php
    include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("demo");
            let captionText = document.getElementById("caption");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }
    </script>
</body>

</html>