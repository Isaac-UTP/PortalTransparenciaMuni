<?php
require_once '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si el archivo fue subido correctamente
    if (!isset($_FILES['archivo'])) {
        header('Location: subir_documento.php?error=no_file');
        exit();
    }

    $archivo = $_FILES['archivo'];

    // Verificar errores de subida
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        header('Location: subir_documento.php?error=upload_error');
        exit();
    }

    // Validar tipo de archivo
    $allowed = ['pdf' => 'application/pdf'];
    $filename = $archivo['name'];
    $filetype = $archivo['type'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (!array_key_exists($ext, $allowed)) {
        header('Location: subir_documento.php?error=invalid_format');
        exit();
    }

    // Validar tamaño (5MB máximo)
    $maxsize = 5 * 1024 * 1024;
    if ($archivo['size'] > $maxsize) {
        header('Location: subir_documento.php?error=file_size');
        exit();
    }

    // Obtener datos del formulario
    $tipos = $_POST['tipos'] ?? null;
    $anno = $_POST['anno'] ?? null;
    $numero = $_POST['numero'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;

    // Validar campos obligatorios
    if (!$tipos || !$anno || !$numero || !$descripcion) {
        header('Location: subir_documento.php?error=missing_fields');
        exit();
    }

    try {
        // Crear directorio si no existe
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/PortalTransparenciaMuni/uploads/' . $tipos . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Mover archivo subido
        $rutaArchivo = $uploadDir . $filename;

        if (file_exists($rutaArchivo)) {
            header('Location: subir_documento.php?error=file_exists');
            exit();
        }

        if (!move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
            header('Location: subir_documento.php?error=upload_failed');
            exit();
        }

        // Insertar en documentos
        $sql = "INSERT INTO documentos (tipo, anno, numero, fecha, descripcion)
                VALUES (:tipo, :anno, :numero, NOW(), :descripcion)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':tipo' => $tipos,
            ':anno' => $anno,
            ':numero' => $numero,
            ':descripcion' => $descripcion
        ]);

        $documento_id = $pdo->lastInsertId();

        // Insertar en mantenimiento
        $relativePath = 'uploads/' . $tipos . '/' . $filename;
        $sql = "INSERT INTO mantenimiento (documento_id, accion, fecha, descripcion, link)
                VALUES (:documento_id, 'Subida', NOW(), :descripcion, :link)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':documento_id' => $documento_id,
            ':descripcion' => $descripcion,
            ':link' => $relativePath
        ]);

        // Redirección exitosa
        header('Location: indexAdmin.php');
        exit();

    } catch (PDOException $e) {
        error_log("Error en upload.php: " . $e->getMessage());
        header('Location: subir_documento.php?error=database_error');
        exit();
    }
} else {
    header('Location: subir_documento.php');
    exit();
}
?>