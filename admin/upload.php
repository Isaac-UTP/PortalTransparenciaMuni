<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.html");
    exit();
}
?>
<?php
require_once '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validar campos obligatorios
        $requiredFields = ['tipos', 'anno', 'numero', 'descripcion'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Error: El campo '$field' es requerido.");
            }
        }

        // Validar archivo
        if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] != 0) {
            throw new Exception("Error: Seleccione un archivo válido.");
        }

        // Configuraciones del archivo
        $allowed = ['pdf' => 'application/pdf'];
        $filename = $_FILES['archivo']['name'];
        $filetype = $_FILES['archivo']['type'];
        $filesize = $_FILES['archivo']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Validar tipo de archivo
        if (!array_key_exists($ext, $allowed) || !in_array($filetype, $allowed)) {
            throw new Exception("Error: Solo se permiten archivos PDF.");
        }

        // Validar tamaño (5MB máximo)
        if ($filesize > 5 * 1024 * 1024) {
            throw new Exception("Error: El archivo excede 5MB.");
        }

        // Validar año (4 dígitos)
        $anno = $_POST['anno'];
        if (!preg_match('/^\d{4}$/', $anno)) {
            throw new Exception("Error: Año inválido. Ejemplo: 2024");
        }

        // Obtener nombre de la categoría
        $tipos = $_POST['tipos'];
        $stmt = $pdo->prepare("SELECT nombre FROM tipos WHERE prefijo = :prefijo");
        $stmt->execute([':prefijo' => $tipos]);
        $nombreCategoria = $stmt->fetchColumn();
        $nombreSanitizado = preg_replace('/[^a-z0-9]/', '_', strtolower($nombreCategoria)); // Usar guiones bajos

        if (!$nombreCategoria) {
            throw new Exception("Error: Categoría no encontrada.");
        }

        // Crear estructura de carpetas DENTRO de public
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/archivos/$nombreSanitizado/$anno/"; // Ruta directa a la carpeta existente

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Permisos de escritura
        }

        // Construir nombre según convención (AC_001_2023_MDNCH.pdf)
        $nombreBase = "{$tipos}-{$_POST['numero']}-{$anno}";
        $nuevoNombreArchivo = "{$nombreBase}_MDNCH.pdf"; // <- Agregar sufijo

        // Mover archivo al destino
        $rutaArchivo = $uploadDir . $nuevoNombreArchivo;
        if (file_exists($rutaArchivo)) {
            throw new Exception("Error: El archivo ya existe.");
        }

        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)) {
            throw new Exception("Error: No se pudo guardar el archivo.");
        }

        // Iniciar transacción SQL
        $pdo->beginTransaction();

        // Insertar en DOCUMENTOS (con descripción)
        $sqlDocumentos = "INSERT INTO documentos 
            (tipo, anno, numero, descripcion, fecha) 
            VALUES (:tipo, :anno, :numero, :descripcion, NOW())";

        $stmt = $pdo->prepare($sqlDocumentos);
        $stmt->execute([
            ':tipo' => $tipos,
            ':anno' => $anno,
            ':numero' => $_POST['numero'],
            ':descripcion' => $_POST['descripcion']
        ]);

        // Insertar en MANTENIMIENTO
        $documento_id = $pdo->lastInsertId();
        $linkParaBD = "$nombreSanitizado/$anno/" . $nuevoNombreArchivo; // Elimina "archivo/" del path

        $sqlMantenimiento = "INSERT INTO mantenimiento 
            (documento_id, accion, fecha, descripcion, link) 
            VALUES (:documento_id, 'Subida', NOW(), :descripcion, :link)";

        $stmt = $pdo->prepare($sqlMantenimiento);
        $stmt->execute([
            ':documento_id' => $documento_id,
            ':descripcion' => $_POST['descripcion'],
            ':link' => $linkParaBD
        ]);

        // Confirmar transacción
        $pdo->commit();

        // Redirigir a confirmación
        header('Location: confirmacion.php');
        exit();

    } catch (Exception $e) {
        // Revertir cambios en caso de error
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        die($e->getMessage());
    }
}
?>