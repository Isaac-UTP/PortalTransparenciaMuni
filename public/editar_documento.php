<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.html");
    exit();
}
?>
<?php
require_once '../connection/db.php';

// Obtener el ID del documento a editar
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Error: ID de documento no proporcionado.");
}

// Obtener los datos del documento desde la base de datos
$sql = "SELECT * FROM documentos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$documento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$documento) {
    die("Error: Documento no encontrado.");
}

// Obtener los tipos activos desde la base de datos
$sql = "SELECT prefijo, nombre FROM tipos WHERE estado = 'activo'";
$stmt = $pdo->query($sql);
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Documento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/editar_documento.css">
</head>

<body>
    <?php include_once '../templates/navbarAdmin.php'; ?>
    <div class="content">
        <div class="container">
            <h1>Editar Documento</h1>
            <form action="update_documento.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($documento['id']) ?>">
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
                <div class="mb-3">
                    <label for="archivo" class="form-label">Archivo:</label>
                    <input type="file" name="archivo" id="archivo" class="form-control">
                    <small>Deja este campo vacío si no deseas cambiar el archivo.</small>
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