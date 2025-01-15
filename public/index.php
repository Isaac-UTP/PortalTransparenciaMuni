<?php
require_once '../connection/db.php';

// Obtener los tipos desde la base de datos
$sql = "SELECT prefijo, nombre FROM tipos";
$stmt = $pdo->query($sql);
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener los documentos desde la base de datos
$searchTipo = $_GET['tipo'] ?? '';
$searchAnno = $_GET['anno'] ?? '';
$searchKeyword = $_GET['keyword'] ?? '';

$sql = "
    SELECT d.id, t.nombre AS tipos, d.anno, d.descripcion, d.numero, d.link 
    FROM documentos d
    INNER JOIN tipos t ON d.tipos = t.prefijo
    WHERE (:tipo = '' OR d.tipos = :tipo)
    AND (:anno = '' OR d.anno = :anno)
    AND (:keyword = '' OR d.descripcion LIKE :keyword)
    ORDER BY d.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':tipo', $searchTipo);
$stmt->bindValue(':anno', $searchAnno);
$stmt->bindValue(':keyword', '%' . $searchKeyword . '%');
$stmt->execute();
$documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos Subidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../templates/navbar.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-left">
                <h1>Documentos Subidos</h1>
                <form method="GET" action="index.php" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="tipo" class="form-label">Categoría:</label>
                            <select name="tipo" id="tipo" class="form-select">
                                <option value="">-- Selecciona una Categoría --</option>
                                <?php foreach ($tipos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['prefijo']) ?>" <?= $searchTipo == $row['prefijo'] ? 'selected' : '' ?>><?= htmlspecialchars($row['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="anno" class="form-label">Año:</label>
                            <select name="anno" id="anno" class="form-select">
                                <option value="">-- Selecciona un Año --</option>
                                <?php
                                // Obtener los años desde la base de datos
                                $sql = "SELECT DISTINCT anno FROM documentos ORDER BY anno DESC";
                                $stmt = $pdo->query($sql);
                                $annos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($annos as $row): ?>
                                    <option value="<?= htmlspecialchars($row['anno']) ?>" <?= $searchAnno == $row['anno'] ? 'selected' : '' ?>><?= htmlspecialchars($row['anno']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="keyword" class="form-label">Palabras Clave:</label>
                            <input type="text" name="keyword" id="keyword" class="form-control"
                                value="<?= htmlspecialchars($searchKeyword) ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                        <a href=""></a>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Año</th>
                            <th>Número</th>
                            <th>Descripción</th>
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
                                <td><a href="<?= htmlspecialchars($documento['link']) ?>" target="_blank">Ver</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        // Código JavaScript para actualizar la tabla dinámicamente si es necesario
        document.getElementById('tipo').addEventListener('change', function () {
            this.form.submit();
        });
        document.getElementById('anno').addEventListener('change', function () {
            this.form.submit();
        });
        document.getElementById('keyword').addEventListener('input', function () {
            this.form.submit();
        });
    </script>
</body>

</html>