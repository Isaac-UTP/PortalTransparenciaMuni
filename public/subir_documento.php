<?php
require_once '../connection/db.php';

// Obtener los tipos desde la base de datos
$sql = "SELECT prefijo, nombre FROM tipos";
$stmt = $pdo->query($sql);
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Documento</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>

<body>
    <div class="container">
        <h1>Subir Documento</h1>
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tipos" class="form-label">Tipo:</label>
                <select name="tipos" id="tipos" class="form-select" required>
                    <option value="">-- Selecciona un Tipo --</option>
                    <?php foreach ($tipos as $row): ?>
                        <option value="<?= htmlspecialchars($row['prefijo']) ?>"><?= htmlspecialchars($row['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="anno" class="form-label">Año:</label>
                <input type="date" name="anno" id="anno" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="numero">Número:</label>
                <input type="number" name="numero" id="numero" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="archivo" class="form-label">Archivo</label>
                <input type="file" name="archivo" id="archivo" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Subir</button>
            </div>
        </form>
    </div>

    <script src="path/to/bootstrap.bundle.js"></script>
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Evita el envío del formulario por defecto
            var form = this;
            var formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                body: formData
            }).then(response => response.text())
                .then(data => {
                    // Redirigir a la página principal después de subir el documento
                    window.location.href = 'index.php';
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al subir el archivo');
                });
        });
    </script>
</body>

</html>