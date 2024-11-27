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
    <link rel="stylesheet" href="../css/form.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container_graf {
            display: flex;
            width: 100%;
            max-width: 600px;
            padding: 1rem;
        }
    </style>
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        include_once "../conexao.php";
        $ano_atual = date('Y');
        $sql = "SELECT MONTH(data_compra) AS mes, COUNT(*) AS total_compras FROM COMPRA WHERE YEAR(data_compra) = :ano GROUP BY MONTH(data_compra) ORDER BY MONTH(data_compra)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([':ano' => $ano_atual]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $compras_por_mes = array_fill(1, 12, 0);
        foreach ($resultados as $row) {
            $compras_por_mes[intval($row['mes'])] = intval($row['total_compras']);
        }
        $nomes_meses = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        $labels = [];
        $data = [];

        foreach ($compras_por_mes as $mes => $total) {
            $labels[] = $nomes_meses[$mes];
            $data[] = $total;
        }
        //Grafico de Pizza dos status das compras
        $sql_status = "SELECT status_compra, COUNT(*) AS total FROM COMPRA WHERE YEAR(data_compra) = :ano GROUP BY status_compra";
        $stmt_status = $conexao->prepare($sql_status);
        $stmt_status->execute([':ano' => $ano_atual]);
        $resultados_status = $stmt_status->fetchAll(PDO::FETCH_ASSOC);
        $labels_status = [];
        $data_status = [];
        foreach ($resultados_status as $row) {
            $labels_status[] = $row['status_compra'];
            $data_status[] = intval($row['total']);
        }
        ?>
    </header>
    <main>
        <div class="conteudo_central">
            <div class="container_graf">
                <div>
                    <canvas id="comprasGrafico" width="700"></canvas>
                </div>
                <div>
                    <canvas id="statusComprasGrafico" width="350"></canvas>
                </div>
            </div>
        </div>
    </main>
    <?php include_once "../footer.php"; ?>
    <script src="../js/menu.js"></script>
    <script>
        const labels = <?php echo json_encode($labels); ?>;
        const data = <?php echo json_encode($data); ?>;
        //============================= GRAFICO DE BARRAS ============================
        const config = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Número de Compras',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Relatório de Compras'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mês'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Compras por Mês em <?php echo $ano_atual; ?>'
                    },
                    legend: {
                        display: false
                    }
                }
            }
        };
        const comprasGrafico = new Chart(
            document.getElementById('comprasGrafico'),
            config
        );
        //============================= GRAFICO DE PIZZA ============================
        const labelsStatus = <?php echo json_encode($labels_status); ?>;
        const dataStatus = <?php echo json_encode($data_status); ?>;

        const configStatus = {
            type: 'pie',
            data: {
                labels: labelsStatus,
                datasets: [{
                    label: 'Status das Compras',
                    data: dataStatus,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        // Adicione mais cores conforme necessário
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(255, 206, 86, 1)',
                        // Adicione mais cores conforme necessário
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Compras em <?php echo $ano_atual; ?>'
                    },
                    legend: {
                        position: 'top',
                    }
                }
            }
        };

        const statusComprasGrafico = new Chart(
            document.getElementById('statusComprasGrafico'),
            configStatus
        );
    </script>
</body>

</html>