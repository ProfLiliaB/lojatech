    <tbody>
        <?php
    include_once "config.php";
    include_once "../conexao.php";
    $itens_por_pg = 10;
    $pg_atual = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
    if ($pg_atual < 1) {
        $pg_atual = 1;
    }
    $sql = "SELECT * FROM produto p, categoria c WHERE p.id_categoria = c.id_categoria ";
    $offset = ($pg_atual - 1) * $itens_por_pg;
    $limit = 10;
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
    $sql .= " ORDER BY :ordem ASC LIMIT $limit OFFSET $offset";
    $_SESSION['param'] = $_SESSION['param'] ?? $params;
    if (array_diff($params, $_SESSION['param'])) {
        $_SESSION['param'] = $params;
    }
        // echo
        // '<tr>
        //     <td colspan="7">' . $sql . '<br>';
        //     print_r($_SESSION['param']);
        //     print_r($_POST);
        //     echo '
        //     </td>
        // </tr>';
        $select = $conexao->prepare($sql);
        $select->execute($_SESSION['param']);
        $n_paginas = ceil($total_registros / $itens_por_pg);
        while ($res = $select->fetch()) {
            $id_produto = $res['id_produto'];
            $valor_produto = number_format($res['valor'], 2, ',', '.');
        ?>
        <tr>
            <td style="width: 40%;text-align: left;"><?= $res['nome_produto'] ?></td>
            <td><?= $res['nome_categoria'] ?></td>
            <td>
                <?= 'R$ ' . $valor_produto ?></td>
            <td><?= $res['estoque'] ?></td>
            <td>
                <a href="cadastrar_produto.php?id=<?= $id_produto ?>" class="form_btn">Editar</a>
            </td>
            <td><a href="#" class="form_btn">Excluir</a></td>
        </tr>
        <?php
    }
    $inicio = ($pg_atual - 1) * $itens_por_pg + 1;
    $fim = min($pg_atual * $itens_por_pg, $total_registros);
    ?>
    </tbody>
    <tfoot>
    <?php
    $disable_pri = ($pg_atual == 1) ? "style='pointer-events: none;'" : "";
    echo '
    <tr>
        <td colspan="7">
            <div id="paginacao">
                <nav>
                    <ul>
                    <li><a href="?pg=1" title="Primeira" ' . $disable_pri . '> << </a></li>
                    <li><a href="?pg=' . max(1, $pg_atual - 1) . '" title="Próxima" ' . $disable_pri . '> < </a></li>';
                    for ($i = 1; $i <= $n_paginas; $i++):
                        $ativo = ($i == $pg_atual) ? "ativo" : "";
                        echo '<li><a href="?pg=' . $i . '" class="' . $ativo . '">' . $i . '</a></li>';
                    endfor;
                    $disable_ult = ($n_paginas == $pg_atual) ? "style='pointer-events: none;'" : "";
                    echo '<li><a href="?pg=' . min($n_paginas, $pg_atual + 1) . '" title="Próxima" ' . $disable_ult . '> > </a></li>
                    <li><a href="?pg=' . $n_paginas . '" title="Última" ' . $disable_ult . '> >> </a></li>
                    </ul>
                </nav>
            </div>
        </td>
    </tr>';
    echo "
    <tr>
        <td colspan='7'>
            <h5>$inicio a $fim de $total_registros produtos</h5>
        </td>
    </tr>";
    ?>
    </tfoot>