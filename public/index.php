<?php
require_once '../connection/db.php';

// Obtener los tipos desde la base de datos
$sql = "SELECT prefijo, nombre FROM tipos";
$stmt = $pdo->query($sql);
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener los parámetros de búsqueda y paginación
$searchTipo = $_GET['tipo'] ?? '';
$searchAnno = $_GET['anno'] ?? '';
$searchKeyword = $_GET['keyword'] ?? '';
$searchYear = $_GET['year'] ?? '';
$orderBy = $_GET['order_by'] ?? 'd.id';
$orderDir = $_GET['order_dir'] ?? 'DESC';
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Contar el número total de registros
$sqlCount = "
    SELECT COUNT(*) 
    FROM documentos d
    INNER JOIN tipos t ON d.tipos = t.prefijo
    WHERE (:tipo = '' OR d.tipos = :tipo)
    AND (:anno = '' OR d.anno = :anno)
    AND (:keyword = '' OR d.descripcion LIKE :keyword)
    AND (:year = '' OR d.anio = :year)";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->bindValue(':tipo', $searchTipo);
$stmtCount->bindValue(':anno', $searchAnno);
$stmtCount->bindValue(':keyword', '%' . $searchKeyword . '%');
$stmtCount->bindValue(':year', $searchYear);
$stmtCount->execute();
$totalRecords = $stmtCount->fetchColumn();
$totalPages = ceil($totalRecords / $limit);

// Obtener los documentos desde la base de datos con límites y desplazamientos
$sql = "
    SELECT d.id, t.nombre AS tipos, d.anno, d.descripcion, d.numero, d.link, d.anio 
    FROM documentos d
    INNER JOIN tipos t ON d.tipos = t.prefijo
    WHERE (:tipo = '' OR d.tipos = :tipo)
    AND (:anno = '' OR d.anno = :anno)
    AND (:keyword = '' OR d.descripcion LIKE :keyword)
    AND (:year = '' OR d.anio = :year)
    ORDER BY $orderBy $orderDir
    LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':tipo', $searchTipo);
$stmt->bindValue(':anno', $searchAnno);
$stmt->bindValue(':keyword', '%' . $searchKeyword . '%');
$stmt->bindValue(':year', $searchYear);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos Subidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../public/css/styles.css">
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
    <?php include '../templates/navbar.php'; ?>
    <div class="container">
        <div class="row mt-4">
            <div class="col-lg-12 text-left">
                <h2>Publicación de ordenanzas</h2>
                <form method="GET" action="index.php" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="tipo" class="form-label raleway-font"><b>Categoría:</b></label>
                            <select name="tipo" id="tipo" class="form-select">
                                <option value="">-- Selecciona una Categoría --</option>
                                <?php foreach ($tipos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['prefijo']) ?>" <?= $searchTipo == $row['prefijo'] ? 'selected' : '' ?>><?= htmlspecialchars($row['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="anio" class="form-label raleway-font"><b>Año de Subida:</b></label>
                            <select name="year" id="anio" class="form-select">
                                <option value="" selected>-- Selecciona un Año --</option>
                                <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                    <option value="<?= $i ?>" <?= $searchYear == $i ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="keyword" class="form-label raleway-font"><b>Palabras Clave:</b></label>
                            <input type="text" name="keyword" id="keyword" class="form-control"
                                value="<?= htmlspecialchars($searchKeyword) ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-lg-12 text-left">
                        <table class="table table-striped table-bordered" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <th>
                                        Tipo
                                        <a href="?order_by=t.nombre&order_dir=ASC"><i
                                                class="fa-solid fa-up-long"></i></a>
                                        <a href="?order_by=t.nombre&order_dir=DESC"><i
                                                class="fa-solid fa-down-long"></i></a>
                                    </th>
                                    <th>
                                        Año
                                        <a href="?order_by=d.anno&order_dir=ASC"><i class="fa-solid fa-up-long"></i></a>
                                        <a href="?order_by=d.anno&order_dir=DESC"><i
                                                class="fa-solid fa-down-long"></i></a>
                                    </th>
                                    <th>
                                        Número
                                        <a href="?order_by=d.numero&order_dir=ASC"><i
                                                class="fa-solid fa-up-long"></i></a>
                                        <a href="?order_by=d.numero&order_dir=DESC"><i
                                                class="fa-solid fa-down-long"></i></a>
                                    </th>
                                    <th>
                                        Descripción
                                        <a href="?order_by=d.descripcion&order_dir=ASC"><i
                                                class="fa-solid fa-up-long"></i></a>
                                        <a href="?order_by=d.descripcion&order_dir=DESC"><i
                                                class="fa-solid fa-down-long"></i></a>
                                    </th>
                                    <th>Enlace</th>
                                </tr>
                            </thead>
                            <tbody id="documentosTableBody">
                                <?php foreach ($documentos as $documento): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($documento['tipos']) ?></td>
                                        <td><?= htmlspecialchars($documento['anno']) ?></td>
                                        <td><?= htmlspecialchars($documento['numero']) ?></td>
                                        <td><?= htmlspecialchars($documento['descripcion']) ?></td>
                                        <td><a href="<?= htmlspecialchars($documento['link']) ?>" target="_blank"
                                                class="btn btn-warning btn-xs"><i class="fa-solid fa-download"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Paginación -->
                        <!-- Paginación -->
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                            <a class="page-link"
                                                href="?page=<?= $i ?>&order_by=<?= $orderBy ?>&order_dir=<?= $orderDir ?>&tipo=<?= $searchTipo ?>&anno=<?= $searchAnno ?>&keyword=<?= $searchKeyword ?>&year=<?= $searchYear ?>"><?= $i ?></a>
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
    <script>
        // Código JavaScript para actualizar la tabla dinámicamente si es necesario
        document.getElementById('tipo').addEventListener('change', function () {
            this.form.submit();
        });
        document.getElementById('anio').addEventListener('change', function () {
            this.form.submit();
        });
    </script>
</body>

</html>
<style>
    .raleway-font {
        font-family: 'Raleway', sans-serif;
    }
</style>