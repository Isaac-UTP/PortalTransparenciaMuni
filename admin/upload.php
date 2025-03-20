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
            throw new Exception("Error: Problema con el archivo subido.");
        }

        // Configuraciones del archivo
        $allowed = ['pdf' => 'application/pdf'];
        $filename = $_FILES['archivo']['name'];
        $filetype = $_FILES['archivo']['type'];
        $filesize = $_FILES['archivo']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Validaciones
        if (!array_key_exists($ext, $allowed) || !in_array($filetype, $allowed)) {
            throw new Exception("Error: Solo se permiten archivos PDF.");
        }

        if ($filesize > 5 * 1024 * 1024) {
            throw new Exception("Error: El archivo excede 5MB.");
        }

        if (!preg_match('/^\d{4}$/', $_POST['anno'])) {
            throw new Exception("Error: Año inválido (ej: 2024).");
        }

        // Crear estructura de carpetas
        $tipos = $_POST['tipos'];
        $anno = $_POST['anno'];
        $uploadDir = "../uploads/$tipos/$anno/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Mover archivo
        $rutaArchivo = $uploadDir . $filename;
        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)) {
            throw new Exception("Error: No se pudo guardar el archivo.");
        }

        // Insertar en DOCUMENTOS
        $pdo->beginTransaction();

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

        // Insertar en MANTENIMIENTO (ruta relativa desde raíz)
        $documento_id = $pdo->lastInsertId();
        $linkParaBD = "uploads/$tipos/$anno/$filename"; // Ruta sin ../

        $sqlMantenimiento = "INSERT INTO mantenimiento 
            (documento_id, accion, fecha, descripcion, link)
            VALUES (:documento_id, 'Subida', NOW(), :descripcion, :link)";

        $stmt = $pdo->prepare($sqlMantenimiento);
        $stmt->execute([
            ':documento_id' => $documento_id,
            ':descripcion' => $_POST['descripcion'],
            ':link' => $linkParaBD
        ]);

        $pdo->commit();

        header('Location: subido_exitoso.php');
        exit();

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        die($e->getMessage());
    }
}