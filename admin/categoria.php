<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /PORTALTRANSPARENCIAMUNI/login/login.html');
    exit();
}
require_once __DIR__ . '/../connection/db.php';

// Obtener las categorías desde la base de datos
$sql = "SELECT id, codigo, nombre, prefijo, estado FROM tipos";
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
    <link rel="icon" href="../public/img/logo_white.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="stylesheet" href="../public/css/categoria.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include_once '../templates/navbarAdmin.php'; ?>
    <div class="content">
        <div class="container"></div>
        <div class="row mt-4"></div>
        <div class="col-lg-12 text-left"></div>
        <h2>Ver Categorías</h2>
        <div class="row"></div>
        <div class="col-lg-12 text-left"></div>
        <table class="table table-striped table-bordered" style="font-size:12px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Prefijo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?= htmlspecialchars($categoria['id']) ?></td>
                        <td><?= htmlspecialchars($categoria['codigo']) ?></td>
                        <td><?= htmlspecialchars($categoria['nombre']) ?></td>
                        <td><?= htmlspecialchars($categoria['prefijo']) ?></td>
                        <td><?= htmlspecialchars($categoria['estado']) ?></td>
                        <td>
                            <?php if ($categoria['estado'] == 'activo'): ?>
                                <a href="cambiar_estado.php?id=<?= $categoria['id'] ?>&estado=inactivo"
                                    class="btn btn-danger btn-sm">Apagar</a>
                            <?php else: ?>
                                <a href="cambiar_estado.php?id=<?= $categoria['id'] ?>&estado=activo"
                                    class="btn btn-success btn-sm">Encender</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation"></nav>
            <ul class="pagination"></ul>
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