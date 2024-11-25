<section id="produtos">
    <?php
    include_once "conexao.php";
    include_once "admin/config.php";
    $itens_por_pg = 12;
    $pg_atual = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
    if ($pg_atual < 1) {
        $pg_atual = 1;
    }
    $sql = "SELECT * FROM produto p, categoria c WHERE p.id_categoria = c.id_categoria ";
    $offset = ($pg_atual - 1) * $itens_por_pg;
    $filtro = $_POST['filtro'] ?? '';
    $id_cat = $_POST['categoria'] ?? "";
    $valMax = $_POST['valMax'] ?? '';
    $valMin = $_POST['valMin'] ?? 0;
    $ordem = $_POST['ordem'] ?? 'p.nome_produto';
    $params = [];
    if ($valMax) {
        $params = ['valor_min' => floatval($valMin)];
        $valMax = varificaValorMaximo($valMax, floatval($valMin), $conexao);
        $sql .= " AND p.valor BETWEEN :valor_min AND :valor_max";
        $params['valor_max'] = $valMax;
    }
    if ($filtro) {
        $sql .= " AND p.nome_produto LIKE :nome";
        $filtro = htmlspecialchars(strip_tags($filtro));
        $params['nome'] = "%$filtro%";
    }
    if ($id_cat) {
        $sql .= " AND p.id_categoria = :categoria";
        $params['categoria'] = $id_cat;
    }
    $select = $conexao->prepare($sql);
    $select->execute($params);
    $total_registros = $select->rowCount();
    $params['ordem'] = $ordem;
    $sql .= " ORDER BY :ordem ASC LIMIT $itens_por_pg OFFSET $offset";
    $_SESSION['param'] = $_SESSION['param'] ?? $params;
    if (array_diff($params, $_SESSION['param'])) {
        $_SESSION['param'] = $params;
    }
    $select = $conexao->prepare($sql);
    $select->execute($_SESSION['param']);
    $n_paginas = ceil($total_registros / $itens_por_pg);
    while ($prod = $select->fetch()) {
        $valor_produto = number_format($prod['valor'], 2, ',', '.');
        $id_produto = $prod['id_produto'];
        $nome_produto = $prod['nome_produto'];
        $nome_categoria = $prod['nome_categoria'];
        $selectImg = $conexao->prepare("SELECT * FROM imagem WHERE status_imagem = 1 && id_produto = ?");
        $selectImg->execute([$id_produto]);
        if ($selectImg->rowCount()) {
            $imagem = $selectImg->fetch()['nome_imagem'];
        } else {
            $imagem = "celularA54.jfif";
        }
        echo '
    <div class="card">
        <div class="card-header">
            ' . $nome_produto . '
        </div>
        <div class="card-body">
            <a href="detalhes_produto.php">';
        echo '<img src="img/' . $imagem . '" width="200" />';
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
    } ?>
</section>
<section id="paginacao">
    <?php
    $inicio = ($pg_atual - 1) * $itens_por_pg + 1;
    $fim = min($pg_atual * $itens_por_pg, $total_registros);
    $disable_pri = ($pg_atual == 1) ? "style='pointer-events: none;'" : "";
    echo '
    <nav>
        <ul>
            <li><a href="?pg=1" title="Primeira" ' . $disable_pri . '> << </a></li>
            <li><a href="?pg=' . max(1, $pg_atual - 1) . '" title="Anterior" ' . $disable_pri . '> < </a></li>';
    for ($i = 1; $i <= $n_paginas; $i++):
        $ativo = ($i == $pg_atual) ? "ativo" : "";
        echo '
                <li><a href="?pg=' . $i . '" class="' . $ativo . '">' . $i . '</a></li>';
    endfor;
    $disable_ult = ($n_paginas == $pg_atual) ? "style='pointer-events: none;'" : "";
    echo '
            <li><a href="?pg=' . min($n_paginas, $pg_atual + 1) . '" title="Próxima" ' . $disable_ult . '> > </a></li>
            <li><a href="?pg=' . $n_paginas . '" title="Última" ' . $disable_ult . '> >> </a></li>
        </ul>
    </nav>';
    echo "
    <h5>$inicio a $fim de $total_registros produtos</h5>";
    ?>
</section>