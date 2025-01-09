<?php
// Página Principal

require_once '../connection/db.php';

// Obtener los documentos desde la base de datos
$tipo = $_GET['tipo'] ?? '';
$anno = $_GET['anno'] ?? date('Y');
$busqueda = $_GET['busqueda'] ?? '';

$sql = "
    SELECT d.id, t.nombre AS tipo, d.anno, d.descripcion, d.numero, d.fecha 
    FROM documentos d
    INNER JOIN tipos t ON d.tipo = t.prefijo
    WHERE 1";

if ($tipo) {
    $sql .= " AND d.tipo = :tipo";
}
if ($anno) {
    $sql .= " AND d.anno = :anno";
}
if ($busqueda) {
    $sql .= " AND d.descripcion LIKE :busqueda";
}

$stmt = $pdo->prepare($sql);

if ($tipo) {
    $stmt->bindParam(':tipo', $tipo);
}
if ($anno) {
    $stmt->bindParam(':anno', $anno);
}
if ($busqueda) {
    $stmt->bindValue(':busqueda', "%$busqueda%");
}

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
    <link rel="stylesheet" href="css/modal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <h1>Documentos Municipales</h1>
    <form method="GET" action="">
        <select name="tipo">
            <option value="">--TIPOS--</option>
            <?php
            // Obtener tipos desde la base de datos
            $tiposQuery = $pdo->query("SELECT prefijo, nombre FROM tipos");
            $tipos = $tiposQuery->fetchAll(PDO::FETCH_ASSOC);
            foreach ($tipos as $t):
            ?>
                <option value="<?= htmlspecialchars($t['prefijo']) ?>" <?= $tipo === $t['prefijo'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="anno" placeholder="Año" value="<?= htmlspecialchars($anno) ?>">
        <input type="text" name="busqueda" placeholder="Palabra clave" value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit">Buscar</button>
    </form>

    <!-- Tabla de Documentos -->
    <table class="table table-bordered" style="width: 100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Año</th>
                <th>Número</th>
                <th>Descripción</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documentos as $doc): ?>
                <tr>
                    <td><?= htmlspecialchars($doc['id']) ?></td>
                    <td><?= htmlspecialchars($doc['tipo']) ?></td>
                    <td><?= htmlspecialchars($doc['anno']) ?></td>
                    <td><?= htmlspecialchars($doc['numero']) ?></td>
                    <td><?= htmlspecialchars($doc['descripcion']) ?></td>
                    <td><?= htmlspecialchars($doc['fecha']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="js/modal.js"></script>
</body>

</html>
