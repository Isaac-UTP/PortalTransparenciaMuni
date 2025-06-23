<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.html");
    exit();
}

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

        $tipos = $_POST['tipos'];
        $anno = $_POST['anno'];
        $numero = $_POST['numero'];
        $descripcion = $_POST['descripcion'];

        if (!preg_match('/^\d{4}$/', $anno)) {
            throw new Exception("Error: Año inválido. Ejemplo: 2024");
        }

        // Obtener nombre de categoría desde la base de datos
        $stmt = $pdo->prepare("SELECT nombre FROM tipos WHERE prefijo = :prefijo");
        $stmt->execute([':prefijo' => $tipos]);
        $nombreCategoria = $stmt->fetchColumn();

        if (!$nombreCategoria) {
            throw new Exception("Error: Tipo de documento inválido.");
        }

        // Sanear el nombre de la carpeta
        $nombreSanitizado = preg_replace('/[^a-z0-9]/', '_', strtolower($nombreCategoria));
        $nombreBase = "{$tipos}_{$numero}_{$anno}";
        $nombreArchivo = "{$nombreBase}_MDNCH.pdf";

        // ===== CREACIÓN DE CARPETAS (sin subir archivo) =====
        $basePath = $_SERVER['DOCUMENT_ROOT'] . "/PORTALTRANSPARENCIAMUNI/public/archivo";
        $rutaCategoria = "$basePath/$nombreSanitizado";
        $rutaAnno = "$rutaCategoria/$anno";

        if (!is_dir($rutaAnno)) {
            if (!mkdir($rutaAnno, 0755, true)) {
                throw new Exception("Error: No se pudo crear la carpeta '$rutaAnno'. Verifica los permisos del servidor.");
            }
        }

        // Registrar la ruta como si el archivo ya estuviera ahí (el ingeniero lo colocará manualmente)
        $linkParaBD = "archivo/{$nombreSanitizado}/{$anno}/{$nombreArchivo}";

        $pdo->beginTransaction();

        // Insertar en la tabla documentos
        $sqlDocumentos = "INSERT INTO documentos 
            (tipo, anno, numero, descripcion, fecha) 
            VALUES (:tipo, :anno, :numero, :descripcion, NOW())";

        $stmt = $pdo->prepare($sqlDocumentos);
        $stmt->execute([
            ':tipo' => $tipos,
            ':anno' => $anno,
            ':numero' => $numero,
            ':descripcion' => $descripcion
        ]);

        $documento_id = $pdo->lastInsertId();

        // Insertar en la tabla mantenimiento
        $sqlMantenimiento = "INSERT INTO mantenimiento 
            (documento_id, accion, fecha, descripcion, link) 
            VALUES (:documento_id, 'Subida', NOW(), :descripcion, :link)";

        $stmt = $pdo->prepare($sqlMantenimiento);
        $stmt->execute([
            ':documento_id' => $documento_id,
            ':descripcion' => $descripcion,
            ':link' => $linkParaBD
        ]);

        $pdo->commit();
        header('Location: confirmacion.php');
        exit();

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        die("Error: " . $e->getMessage());
    }
}
?>
