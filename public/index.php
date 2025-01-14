<?php
require_once '../connection/db.php';

// Obtener los documentos desde la base de datos
$sql = "
    SELECT d.id, t.nombre AS tipos, d.anno, d.descripcion, d.numero, d.link 
    FROM documentos d
    INNER JOIN tipos t ON d.tipos = t.prefijo
    ORDER BY d.id DESC";
$stmt = $pdo->query($sql);
$documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos Subidos</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>

<body>
    <div class="container">
        <h1>Documentos Subidos</h1>
        <a href="subir_documento.php" class="btn btn-primary mb-3">Subir Documento</a>
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

    <script src="path/to/bootstrap.bundle.js"></script>
    <script>
        // Código JavaScript para actualizar la tabla dinámicamente si es necesario
    </script>
</body>

</html>