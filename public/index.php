<?php
//Pagina Principal

require_once '../includes/db.php';

// Obtener los documentos desde la base de datos
$categoria = $_GET['categoria'] ?? '';
$anio = $_GET['anio'] ?? date('Y');
$busqueda = $_GET['busqueda'] ?? '';

$sql = "SELECT * FROM documentos WHERE 1";
if ($categoria) {
    $sql .= " AND categoria = :categoria";
}
if ($anio) {
    $sql .= " AND anio = :anio";
}
if ($busqueda) {
    $sql .= " AND descripcion LIKE :busqueda";
}
$stmt = $pdo->prepare($sql);

if ($categoria) $stmt->bindParam(':categoria', $categoria);
if ($anio) $stmt->bindParam(':anio', $anio);
if ($busqueda) $stmt->bindValue(':busqueda', "%$busqueda%");

$stmt->execute();
$documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos Municipales</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Documentos Municipales</h1>
    <form method="GET" action="">
        <select name="categoria">
            <option value="">--CATEGORÍAS--</option>
            <option value="ORDENANZA MUNICIPAL" <?= $categoria === 'ORDENANZA MUNICIPAL' ? 'selected' : '' ?>>ORDENANZA MUNICIPAL</option>
            <option value="RESOLUCIONES ALCALDIA" <?= $categoria === 'RESOLUCIONES ALCALDIA' ? 'selected' : '' ?>>RESOLUCIONES ALCALDIA</option>
            <option value="DECRETOS ALCALDIA" <?= $categoria === 'DECRETOS ALCALDIA' ? 'selected' : '' ?>>DECRETOS ALCALDIA</option>
            <option value="ACUERDOS CONSEJO" <?= $categoria === 'ACUERDOS CONSEJO' ? 'selected' : '' ?>>ACUERDOS CONSEJO</option>
            <option value="RESOLUCIONES GERENCIALES" <?= $categoria === 'RESOLUCIONES GERENCIALES' ? 'selected' : '' ?>>RESOLUCIONES GERENCIALES</option>
        </select>
        <input type="number" name="anio" placeholder="Año" value="<?= htmlspecialchars($anio) ?>">
        <input type="text" name="busqueda" placeholder="Palabra clave" value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit">Buscar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Categoría</th>
                <th>Año</th>
                <th>Descripción</th>
                <th>Archivo</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documentos as $doc): ?>
                <tr>
                    <td><?= htmlspecialchars($doc['id']) ?></td>
                    <td><?= htmlspecialchars($doc['categoria']) ?></td>
                    <td><?= htmlspecialchars($doc['anio']) ?></td>
                    <td><?= htmlspecialchars($doc['descripcion']) ?></td>
                    <td><a href="uploads/<?= htmlspecialchars($doc['nombre_archivo']) ?>" target="_blank">Descargar</a></td>
                    <td><?= htmlspecialchars($doc['fecha_subida']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
