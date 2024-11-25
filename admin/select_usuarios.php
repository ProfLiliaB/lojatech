<tbody>
    <?php
    include_once "config.php";
    include_once "../conexao.php";
    $itens_por_pg = 10;
    $pg_atual = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
    if ($pg_atual < 1) {
        $pg_atual = 1;
    }
    $sql = "SELECT * FROM usuario WHERE id_usuario > 0";
    $offset = ($pg_atual - 1) * $itens_por_pg;
    $limit = 10;
    $filtro = $_POST['filtro'] ?? '';

    $ordem = $_POST['ordem'] ?? 'nome';
    $params = [];

    if ($filtro) {
        $sql .= " AND nome LIKE :nome";
        $filtro = htmlspecialchars(strip_tags($filtro));
        $params['nome'] = "%$filtro%";
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

    $select = $conexao->prepare($sql);
    $select->execute($_SESSION['param']);
    $n_paginas = ceil($total_registros / $itens_por_pg);
    while ($res = $select->fetch()) {
        $id_usuario = $res['id_usuario'];
    ?>
        <tr>
            <td style="width: 40%;text-align: left;"><?= $res['nome'] ?></td>
            <td><?= $res['email'] ?></td>
            <td><?= $res['cpf'] ?></td>
            <td>
                <a href="cadastrar_usuario.php?id=<?= $id_usuario ?>" class="form_btn">Editar</a>
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
            <h5>$inicio a $fim de $total_registros usuarios</h5>
        </td>
    </tr>";
    ?>
</tfoot>