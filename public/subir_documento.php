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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        .form-label {
            font-weight: bold;
            color: #555;
        }

        .btn-primary {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        .btn-primary:hover {
            background-color: #45a049;
            border-color: #45a049;
        }
    </style>
</head>
<body>
<?php include '../templates/navbarAdmin.php'; ?>
<div class="content">
    <div class="container">
        <h1><i class="bi bi-cloud-arrow-up"></i> Subir Documento</h1>
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
            <div class="modal-footer d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary">Subir</button> <br>
                <a type="button" href="index.php" class="btn btn-warning">Volver al Inicio</a>
            </div>
        </form>
    </div>
</div>

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