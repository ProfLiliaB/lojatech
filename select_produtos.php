<section id="produtos">
    <?php
    //===================================================================================================
    include_once "conexao.php";
    include_once "admin/config.php";

    $itens_por_pg = 12;
    $pg_atual = isset($_GET['pg']) ? max(1, intval($_GET['pg'])) : 1;
    $offset = ($pg_atual - 1) * $itens_por_pg;
    // Sanitização e validação dos filtros
    $filtro = isset($_POST['filtro']) ? htmlspecialchars(strip_tags($_POST['filtro'])) : '';
    $id_cat = isset($_POST['categoria']) ? intval($_POST['categoria']) : '';
    $valMax = isset($_POST['valMax']) ? floatval($_POST['valMax']) : null;
    $valMin = isset($_POST['valMin']) ? floatval($_POST['valMin']) : 0;
    $ordem =  isset($_POST['ordem']) ? $_POST['ordem'] : 'p.nome_produto';
    // Construção dinâmica da query
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM produto p
        JOIN categoria c ON p.id_categoria = c.id_categoria
        WHERE 1";
    $params = [];
    if ($valMax !== null) {
        $sql .= " AND p.valor BETWEEN :valor_min AND :valor_max";
        $params['valor_min'] = $valMin;
        $params['valor_max'] = $valMax;
    }
    if ($filtro) {
        $sql .= " AND p.nome_produto LIKE :nome";
        $params['nome'] = "%$filtro%";
    }
    if ($id_cat) {
        $sql .= " AND p.id_categoria = :categoria";
        $params['categoria'] = $id_cat;
    }
    $sql .= " ORDER BY $ordem LIMIT $itens_por_pg OFFSET $offset";
    $select = $conexao->prepare($sql);
    $select->execute($params);
    $produtos = $select->fetchAll(PDO::FETCH_ASSOC);
    // Contagem total de registros
    $total_registros = $conexao->query("SELECT FOUND_ROWS()")->fetchColumn();
    $n_paginas = ceil($total_registros / $itens_por_pg);
    // Renderização dos produtos
    $imagem['nome_imagem'] = "celularA54.jfif";
    foreach ($produtos as $prod) {
        $valor_produto = number_format($prod['valor'], 2, ',', '.');
        $valor_produto = number_format($prod['valor'], 2, ',', '.');
        $id_produto = $prod['id_produto'];
        $nome_produto = $prod['nome_produto'];
        $nome_categoria = $prod['nome_categoria'];
        $selectImg = $conexao->prepare("SELECT * FROM imagem WHERE status_imagem = 1 && id_produto = ?");
        $selectImg->execute([$id_produto]);
        if ($selectImg->rowCount()) {
            $imagem = $selectImg->fetch();
        } else {
            $imagem['nome_imagem'] = "celularA54.jfif";
        }
        echo '
        <div class="card">
            <div class="card-header">
                ' . $nome_produto . '
            </div>
            <div class="card-body">
                <a href="detalhes_produto.php?id=' . $id_produto . '">';
        echo '<img src="' . DIRETORIO . '/' . $imagem['nome_imagem'] . '" width="200" />';
        echo '</a>
            </div>
            <div class="card-footer">
                <div class="card-valor">R$ ' . $valor_produto . '</div>
                <div class="card-oferta">R$ ' . $valor_produto . '</div>
                <div class="btn-comprar">
                    <button class="comprar" id="comprar' . $id_produto . '" type="button" value="' . $id_produto . '">Comprar</button>
                </div>
                <div class="star">
                    <span>☆</span>
                    <span>☆</span>
                    <span>☆</span>
                    <span>☆</span>
                    <span>☆</span>
                </div>
            </div>
        </div>';
    }
    ?>
</section>
<section id='paginacao'>
    <?php
    $gets = $params;
    $gets['ordem'] = $ordem;
    $query_string = http_build_query($gets);
    $desa_primeira = $pg_atual == 1 ? "disabled" : "";
    $desa_ultima = $pg_atual == $n_paginas ? "disabled" : "";
    $pg_inicial = max(1, $pg_atual - 1);
    $pg_final = min($n_paginas, $pg_atual + 1);
    $inicio = ($pg_atual - 1) * $itens_por_pg + 1;
    $fim = min($pg_atual * $itens_por_pg, $total_registros);
    echo "
    <h5>$inicio a $fim de $total_registros produtos</h5>
    <nav>
        <ul>
            <li><a href='?pg=1&$query_string' class='" .$desa_primeira. "'> << </a></li>
            <li><a href='?pg=" .$pg_inicial."&$query_string' class='" .$desa_primeira. "'> < </a></li>";
            for ($i = 1; $i <= $n_paginas; $i++) {
                $ativo = $i == $pg_atual ? "ativo" : "";
                echo "<li><a href='?pg=$i&$query_string' class='$ativo'>$i</a></li>";
            }
            echo "
            <li><a href='?pg=" .$pg_final. "&$query_string' class='" .$desa_ultima. "'> > </a></li>
            <li><a href='?pg=$n_paginas&$query_string' class='" .$desa_ultima. "'> >> </a></li>
        </ul>
        
    </nav>";
    ?>
</section>