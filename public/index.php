<?php
require_once '../connection/db.php';

// Obtener los tipos desde la base de datos
$sql = "SELECT prefijo, nombre FROM tipos";
$stmt = $pdo->query($sql);
$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Portal de Transparencia</title>
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

        <!-- Tabla de Documentos -->
        <h2>Documentos Subidos</h2>
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
        document.getElementById('uploadForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Evita el envío del formulario por defecto
            var form = this;
            var formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                body: formData
            }).then(response => response.text())
                .then(data => {
                    // Actualizar la tabla de documentos
                    fetch('get_documentos.php')
                        .then(response => response.json())
                        .then(documentos => {
                            var tableBody = document.getElementById('documentosTableBody');
                            tableBody.innerHTML = '';
                            documentos.forEach(documento => {
                                var row = document.createElement('tr');
                                row.innerHTML = `
                                  <td>${documento.tipos}</td>
                                  <td>${documento.anno}</td>
                                  <td>${documento.numero}</td>
                                  <td>${documento.descripcion}</td>
                                  <td><a href="${documento.link}" target="_blank">Ver</a></td>
                              `;
                                tableBody.appendChild(row);
                            });
                        });

                    // Limpiar el formulario
                    form.reset();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al subir el archivo');
                });
        });
    </script>
</body>

</html>