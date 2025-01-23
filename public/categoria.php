<?php
require_once '../connection/db.php';

// Obtener las categorías desde la base de datos
$sql = "SELECT id, codigo, nombre, prefijo FROM tipos";
$stmt = $pdo->query($sql);
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Parámetros de paginación
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Contar el número total de registros
$sqlCount = "SELECT COUNT(*) FROM tipos";
$stmtCount = $pdo->query($sqlCount);
$totalRecords = $stmtCount->fetchColumn();
$totalPages = ceil($totalRecords / $limit);

function generarPaginacion($totalPages, $page, $maxPaginas = 6)
{
    $paginacion = [];

    if ($totalPages <= $maxPaginas) {
        for ($i = 1; $i <= $totalPages; $i++) {
            $paginacion[] = $i;
        }
    } else {
        $paginacion[] = 1;
        $paginacion[] = 2;
        $paginacion[] = 3;

        if ($page > 4 && $page < $totalPages - 3) {
            $paginacion[] = '...';
            $paginacion[] = $page - 1;
            $paginacion[] = $page;
            $paginacion[] = $page + 1;
            $paginacion[] = '...';
        } else {
            $paginacion[] = '...';
        }

        $paginacion[] = $totalPages - 2;
        $paginacion[] = $totalPages - 1;
        $paginacion[] = $totalPages;
    }

    return $paginacion;
}

$paginacion = generarPaginacion($totalPages, $page);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Categorías</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .raleway-font {
            font-family: 'Raleway', sans-serif;
        }
    </style>
</head>

<body>
    <?php include '../templates/navbarAdmin.php'; ?>
    <div class="content">
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-12 text-left">
                    <h2>Ver Categorías</h2>
                    <div class="row">
                        <div class="col-lg-12 text-left">
                            <table class="table table-striped table-bordered" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Prefijo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($categoria['id']) ?></td>
                                            <td><?= htmlspecialchars($categoria['codigo']) ?></td>
                                            <td><?= htmlspecialchars($categoria['nombre']) ?></td>
                                            <td><?= htmlspecialchars($categoria['prefijo']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- Paginación -->
                            <div class="d-flex justify-content-center">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>