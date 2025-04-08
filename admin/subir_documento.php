<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /PORTALTRANSPARENCIAMUNI/login/login.html');
    exit();
}

require_once __DIR__ . '/../connection/db.php';

// Obtener los tipos activos desde la base de datos
$sql = "SELECT prefijo, nombre FROM tipos WHERE estado = 'activo'"; // Query para obtener los tipos activos
$stmt = $pdo->query($sql); // Ejecutar la query
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener los resultados de la query
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/img/logo_white.ico" type="image/x-icon">
    <title>Subir Documento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../public/css/subir_documento.css">
</head>

<body>
    <?php include_once '../templates/navbarAdmin.php'; ?>
    <div class="content">
        <div class="container">
            <h1>Subir Documento</h1>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="tipos" class="form-label">Tipo de Documento:</label>
                    <select name="tipos" id="tipos" class="form-select" required>
                        <option value="">-- Selecciona un Tipo --</option>
                        <?php foreach ($tipos as $tipo): ?>
                            <option value="<?= htmlspecialchars($tipo['prefijo']) ?>">
                                <?= htmlspecialchars($tipo['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="anno" class="form-label">Año:</label>
                    <input type="text" name="anno" id="anno" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="numero" class="form-label">Número:</label>
                    <input type="text" name="numero" id="numero" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="archivo" class="form-label">Archivo:</label>
                    <input type="file" name="archivo" id="archivo" class="form-control" required>
                </div>
                <div class="modal-footer d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success">Subir Documento</button>
                    <a type="button" href="indexAdmin.php" class="btn btn-warning">Volver al Inicio</a>
                </div>
            </form>
        </div>
    </div>
</body>

<!-- Modal de errores -->
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

        <?php if (isset($_GET['error'])): ?>
            errorModal.show();
            setTimeout(() => errorModal.hide(), 5000);
        <?php endif; ?>
    });
</script>

</html>