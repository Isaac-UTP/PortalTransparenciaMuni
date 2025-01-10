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

//
// Verificar si se envió el formulario para subir un archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    $tipos = $_POST['tipos'] ?? '';
    $anio = $_POST['anio'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $archivo = $_FILES['archivo'];

    // Verificar si el archivo es válido
    if ($tipos && $anio && $descripcion && $archivo['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $archivo['name'];
        $rutaDestino = "../uploads/" . $nombreArchivo;

        // Mover el archivo al directorio 'uploads'
        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            // Insertar en la base de datos
            $sql = "INSERT INTO documentos (tipo, anno, descripcion, nombre_archivo, fecha_subida) 
                    VALUES (:tipo, :anio, :descripcion, :nombre_archivo, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':tipo', $tipos);
            $stmt->bindParam(':anio', $anio);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':nombre_archivo', $nombreArchivo);

            if ($stmt->execute()) {
                $mensaje = "Archivo subido con éxito.";
            } else {
                $mensaje = "Error al guardar los datos en la base de datos.";
            }
        } else {
            $mensaje = "Error al mover el archivo.";
        }
    } else {
        $mensaje = "Por favor complete todos los campos y asegúrese de subir un archivo válido.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicación de ordenanzas</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/modal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <h1>Publicación de ordenanzas</h1>
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

    <button id="openModalBtn">Subir Archivo</button>

    <!-- Modal -->
<div id="uploadModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadForm" action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo:</label>
                        <select name="tipo" id="tipo" class="form-select" required>
                            <option value="">-- Selecciona un Tipo --</option>
                            <?php
                            // Obtener los tipos desde la base de datos
                            $sql = "SELECT prefijo, nombre FROM tipos";
                            $stmt = $pdo->query($sql);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . htmlspecialchars($row['prefijo']) . '">' . htmlspecialchars($row['nombre']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="anio" class="form-label">Fecha</label>
                        <input type="date" class="form-control limitar-caracteres" id="anno" name="anno" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="numero">Número:</label>
                        <input type="number" name="numero" id="numero" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" name="descripcion" id="descripcion" required>
                    </div>
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo</label>
                        <input type="file" name="archivo" id="archivo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Subir</button>
                </div>
            </form>
        </div>
    </div>
</div>


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

<script>
document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el envío del formulario por defecto
    var form = this;
    var formData = new FormData(form);

    fetch(form.action, {
        method: form.method,
        body: formData
    }).then(response => {
        if (response.ok) {
            // Cierra el modal aquí
            var modal = document.getElementById('myModal'); // Asegúrate de que el id del modal sea 'myModal'
            var modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
        } else {
            // Maneja el error aquí
            alert('Error al subir el archivo');
        }
    }).catch(error => {
        console.error('Error:', error);
        alert('Error al subir el archivo');
    });
});
</script>