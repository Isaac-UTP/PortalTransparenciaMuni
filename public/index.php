<?php
//Pagina Principal

require_once '../connection/db.php';

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

if ($categoria)
    $stmt->bindParam(':categoria', $categoria);
if ($anio)
    $stmt->bindParam(':anio', $anio);
if ($busqueda)
    $stmt->bindValue(':busqueda', "%$busqueda%");

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
    <!-- Importacion Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>
    <!-- Importacion de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <h1>Documentos Municipales</h1>
    <div class="x-grid gap-2 d-flex justify-content-center">
        <button id="openModalBtn" class="btn btn-primary" type="button">Subir Archivo</button>
    </div>


    <!-- Modal -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModalBtn">&times;</span>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <label for="categoria">Categoría:</label>
                <input type="text" name="categoria" id="categoria" placeholder="Categoría" required><br><br>
                <label for="anio">Año:</label>
                <input type="number" name="anio" id="anio" placeholder="Año" required><br><br>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" placeholder="Descripción" required></textarea><br><br>
                <label for="archivo">Archivo:</label>
                <input type="file" name="archivo" id="archivo" required><br><br>
                <button type="submit">Subir</button>
            </form>
        </div>
    </div>

    <form method="GET" action="">
        <select name="categoria">
            <option value="">--CATEGORÍAS--</option>
            <option value="ORDENANZA MUNICIPAL" <?= $categoria === 'ORDENANZA MUNICIPAL' ? 'selected' : '' ?>>ORDENANZA
                MUNICIPAL</option>
            <option value="RESOLUCIONES ALCALDIA" <?= $categoria === 'RESOLUCIONES ALCALDIA' ? 'selected' : '' ?>>
                RESOLUCIONES ALCALDIA</option>
            <option value="DECRETOS ALCALDIA" <?= $categoria === 'DECRETOS ALCALDIA' ? 'selected' : '' ?>>DECRETOS ALCALDIA
            </option>
            <option value="ACUERDOS CONSEJO" <?= $categoria === 'ACUERDOS CONSEJO' ? 'selected' : '' ?>>ACUERDOS CONSEJO
            </option>
            <option value="RESOLUCIONES GERENCIALES" <?= $categoria === 'RESOLUCIONES GERENCIALES' ? 'selected' : '' ?>>
                RESOLUCIONES GERENCIALES</option>
        </select>
        <input type="number" name="anio" placeholder="Año" value="<?= htmlspecialchars($anio) ?>">
        <input type="text" name="busqueda" placeholder="Palabra clave" value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit">Buscar</button>
    </form>
    <!-- Tabla de Documentos -->
    <table class="table table-bordered" style="width: 65%;">
        <!-- Tipo de tabla + Tamaño de la tabla -->
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

    <script src="js/modal.js"></script>
</body>

</html>