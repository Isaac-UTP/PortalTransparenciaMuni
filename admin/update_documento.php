<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /PORTALTRANSPARENCIAMUNI/login/login.html');
    exit();
}

require_once __DIR__ . '/../connection/db.php';

// Verificar si se ha proporcionado un ID de documento
if (!isset($_POST['id'])) {
    die("Error: ID de documento no proporcionado.");
}

$documento_id = $_POST['id'];

// Obtener los datos del documento existente
$sql = "SELECT * FROM documentos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $documento_id);
$stmt->execute();
$documento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$documento) {
    die("Error: Documento no encontrado.");
}

// Obtener los tipos activos desde la base de datos
$sql = "SELECT prefijo, nombre FROM tipos WHERE estado = 'activo'";
$stmt = $pdo->query($sql);
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $tipos = $_POST['tipos'] ?? null;
    $anno = $_POST['anno'] ?? null;
    $numero = $_POST['numero'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;

    if (!$tipos || !$anno || !$numero || !$descripcion) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Actualizar los datos del documento en la base de datos
    $sql = "UPDATE documentos SET tipo = :tipo, anno = :anno, numero = :numero, descripcion = :descripcion WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':tipo', $tipos);
    $stmt->bindParam(':anno', $anno);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':id', $documento_id);

    if ($stmt->execute()) {
        header("Location: confirmacion.php?redirect=indexAdmin.php");
        exit();
    } else {
        echo "Error al actualizar los datos en la base de datos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Documento</title>
    <link rel="icon" href="../public/img/logo_white.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../public/css/editar_documento.css">
</head>

<body>
    <?php include_once '../templates/navbarAdmin.php'; ?>
    <div class="content">
        <div class="container">
            <h1>Editar Documento</h1>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($documento_id) ?>">
                <div class="mb-3">
                    <label for="tipos" class="form-label">Tipo de Documento:</label>
                    <select name="tipos" id="tipos" class="form-select" required>
                        <option value="">-- Selecciona un Tipo --</option>
                        <?php foreach ($tipos as $tipo): ?>
                            <option value="<?= htmlspecialchars($tipo['prefijo']) ?>"
                                <?= $documento['tipo'] == $tipo['prefijo'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tipo['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="anno" class="form-label">Año:</label>
                    <input type="text" name="anno" id="anno" class="form-control"
                        value="<?= htmlspecialchars($documento['anno']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="numero" class="form-label">Número:</label>
                    <input type="text" name="numero" id="numero" class="form-control"
                        value="<?= htmlspecialchars($documento['NUMERO']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control"
                        value="<?= htmlspecialchars($documento['descripcion']) ?>" required>
                </div>
                <div class="modal-footer d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success">Actualizar Documento</button>
                    <a type="button" href="VerDocumentos.php" class="btn btn-warning">Volver</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>