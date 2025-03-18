<?php
require_once '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validar campos obligatorios
    $required = ['tipos', 'anno', 'numero', 'descripcion'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            die("Error: El campo $field es requerido.");
        }
    }

    // Validar archivo
    if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
        die("Error: Archivo inválido o no subido.");
    }

    $allowed = ['pdf' => 'application/pdf'];
    $filename = basename($_FILES['archivo']['name']);
    $filetype = $_FILES['archivo']['type'];
    $filesize = $_FILES['archivo']['size'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Validar tipo de archivo
    if (!array_key_exists($ext, $allowed) || !in_array($filetype, $allowed)) {
        die("Error: Solo se permiten archivos PDF.");
    }

    // Tamaño máximo 10MB
    if ($filesize > 10 * 1024 * 1024) {
        die("Error: El archivo excede el límite de 10MB.");
    }

    // Sanitizar nombre de archivo
    $safe_filename = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $filename);
    $tipos = $_POST['tipos'];
    $uploadDir = "../uploads/$tipos/";
    $rutaWeb = "uploads/$tipos/$safe_filename"; // Ruta accesible desde navegador

    try {
        $pdo->beginTransaction();

        // Verificar si la categoría existe
        $stmt = $pdo->prepare("SELECT prefijo FROM tipos WHERE prefijo = :prefijo");
        $stmt->execute([':prefijo' => $tipos]);
        if (!$stmt->fetch()) {
            throw new Exception("Categoría inválida.");
        }

        // Crear directorio si no existe
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Error al crear directorio.");
            }
        }

        // Mover archivo
        $rutaCompleta = $uploadDir . $safe_filename;
        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaCompleta)) {
            throw new Exception("Error al subir el archivo.");
        }

        // Insertar documento
        $sql = "INSERT INTO documentos (tipo, anno, numero, fecha, descripcion)
                VALUES (:tipo, :anno, :numero, NOW(), :descripcion)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':tipo' => $tipos,
            ':anno' => $_POST['anno'],
            ':numero' => $_POST['numero'],
            ':descripcion' => $_POST['descripcion']
        ]);
        $documento_id = $pdo->lastInsertId();

        // Registrar en mantenimiento
        $sql = "INSERT INTO mantenimiento (documento_id, accion, fecha, descripcion, link)
                VALUES (:documento_id, 'Subida', NOW(), :descripcion, :link)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':documento_id' => $documento_id,
            ':descripcion' => $_POST['descripcion'],
            ':link' => $rutaWeb
        ]);

        $pdo->commit();
        header("Location: subir_documento.php?success=1");
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack();
        @unlink($rutaCompleta); // Eliminar archivo subido en caso de error
        die("Error de base de datos: " . $e->getMessage());
    } catch (Exception $e) {
        $pdo->rollBack();
        @unlink($rutaCompleta);
        die($e->getMessage());
    }
}