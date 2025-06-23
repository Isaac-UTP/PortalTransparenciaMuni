<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /PORTALTRANSPARENCIAMUNI/login/login.html');
    exit();
}
require_once __DIR__ . '/../connection/db.php';

$currentYear = date('Y');

// Gráfico 1: Cantidad de documentos por tipo (solo tipos activos y por año)
$sqlTipos = "SELECT t.nombre, COUNT(d.id) as cantidad
             FROM tipos t
             LEFT JOIN documentos d ON t.prefijo = d.tipo AND YEAR(d.fecha) = :year
             WHERE t.estado = 'activo'
             GROUP BY t.nombre";
$stmtTipos = $pdo->prepare($sqlTipos);
$stmtTipos->execute([':year' => $currentYear]);
$tiposData = $stmtTipos->fetchAll(PDO::FETCH_ASSOC);

// Gráfico 2: Documentos subidos por mes del año actual
$sqlMeses = "SELECT MONTH(fecha) as mes, COUNT(*) as cantidad
             FROM documentos
             WHERE YEAR(fecha) = :year
             GROUP BY mes";
$stmtMeses = $pdo->prepare($sqlMeses);
$stmtMeses->execute([':year' => $currentYear]);
$mesesData = $stmtMeses->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="icon" href="../public/img/logo_white.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <style>
        body {
            margin: 0;
        }
    </style>
</head>
<body>
    <?php include_once '../templates/navbarAdmin.php'; ?>
    <div class="content" style="margin-left: 250px;">
        <div class="container mt-4">
            <h2 class="mb-4">📊 Panel Estadístico</h2>
            <div class="chart-wrapper">
                <div class="chart-box">
                    <h5>Cantidad de Documentos por Tipo (<?= $currentYear ?>)</h5>
                    <canvas id="documentTypeChart" height="200"></canvas>
                </div>
                <div class="chart-box">
                    <h5>Documentos Subidos por Mes (<?= $currentYear ?>)</h5>
                    <canvas id="documentUploadChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        const tipoLabels = <?= json_encode(array_column($tiposData, 'nombre')) ?>;
        const tipoData = <?= json_encode(array_column($tiposData, 'cantidad')) ?>;

        new Chart(document.getElementById('documentTypeChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: tipoLabels,
                datasets: [{
                    label: 'Cantidad',
                    data: tipoData,
                    borderWidth: 1,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                       'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        const documentosPorMes = Array(12).fill(0);
        const datosMeses = <?= json_encode($mesesData) ?>;
        Object.keys(datosMeses).forEach(m => {
            documentosPorMes[parseInt(m) - 1] = datosMeses[m];
        });

        new Chart(document.getElementById('documentUploadChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Documentos',
                    data: documentosPorMes,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
</body>
</html>

