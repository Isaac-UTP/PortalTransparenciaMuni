<?php
require_once '../connection/db.php';

// Obtener parámetros de búsqueda
$searchTipo = $_GET['tipo'] ?? '';
$searchAnno = $_GET['anno'] ?? '';
$searchKeyword = $_GET['keyword'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Consulta SQL CORREGIDA
$sql = "
    SELECT d.id, t.nombre AS tipos, d.anno, d.numero, d.descripcion, 
           m.link AS link 
    FROM documentos d
    INNER JOIN tipos t ON d.tipo = t.prefijo
    LEFT JOIN mantenimiento m ON d.id = m.documento_id
    WHERE (:tipo = '' OR d.tipo = :tipo)
    AND (:anno = '' OR d.anno = :anno)
    AND (:keyword = '' OR m.descripcion LIKE :keyword)
    ORDER BY d.id DESC
    LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':tipo', $searchTipo);
$stmt->bindValue(':anno', $searchAnno);
$stmt->bindValue(':keyword', '%' . $searchKeyword . '%');
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
    <link rel="icon" href="../public/img/logo_white.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/ver_documentos.css">
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
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-12 text-left">
                    <h2>Publicación de ordenanzas</h2>
                    <form method="GET" action="VerDocumentos.php" class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="tipo" class="form-label raleway-font"><b>Categoría:</b></label>
                                <select name="tipo" id="tipo" class="form-select">
                                    <option value="">-- Selecciona una Categoría --</option>
                                    <?php foreach ($tipos as $row): ?>
                                        <option value="<?= htmlspecialchars($row['prefijo']) ?>"
                                            <?= ($searchTipo == $row['prefijo'] || $row['prefijo'] == 'OM') ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="anio" class="form-label raleway-font"><b>Año de Subida:</b></label>
                                <select name="anno" id="anio" class="form-select">
                                    <option value="" selected>-- Selecciona un Año --</option>
                                    <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                        <option value="<?= $i ?>" <?= $searchAnno == $i ? 'selected' : '' ?>><?= $i ?></option>
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
                                        <th>Tipo</th>
                                        <th>Año</th>
                                        <th>Número</th>
                                        <th>Descripción</th>
                                        <th>Enlace</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="documentosTableBody">
                                    <?php foreach ($documentos as $documento): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($documento['tipos']) ?></td>
                                            <td><?= htmlspecialchars($documento['anno']) ?></td>
                                            <td><?= htmlspecialchars($documento['numero']) ?></td>
                                            <td><?= htmlspecialchars($documento['descripcion']) ?></td>
                                            <td>
                                                <a href="<?= htmlspecialchars($documento['link']) ?>" target="_blank">
                                                    <i class="fa-solid fa-download"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="editar_documento.php?id=<?= $documento['id'] ?>"
                                                    class="btn btn-primary btn-xs Btn">
                                                    <svg class="svg" viewBox="0 0 512 512">
                                                        <path
                                                            d="M362.7 19.3c-25.7 0-51.4 9.8-71 29.3L250.3 90 422 261.7l41.4-41.4c39-39 39-102.2 0-141.2l-21.9-21.9c-19.5-19.5-45.2-29.3-70.9-29.3zM229.7 110.3L19.3 320.7c-5.8 5.8-9.3 13.6-10.6 21.8L.1 478.1c-1.3 8.5 1.6 17.1 7.7 23.2s14.7 9 23.2 7.7l135.6-8.6c8.2-1.3 16-4.8 21.8-10.6l210.4-210.4L229.7 110.3z" />
                                                    </svg>
                                                </a>
                                            </td>
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
                                                <a class="page-link"
                                                    href="?page=<?= $i ?>&order_by=<?= $orderBy ?>&order_dir=<?= $orderDir ?>&tipo=<?= $searchTipo ?>&anno=<?= $searchAnno ?>&keyword=<?= $searchKeyword ?>"><?= $i ?></a>
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
    <script src="../public/js/ver_documentos.js"></script>
</body>

</html>