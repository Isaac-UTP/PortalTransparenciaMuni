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

        // Validar año (4 dígitos)
        if (!preg_match('/^\d{4}$/', $anno)) {
            throw new Exception("Error: Año inválido. Ejemplo: 2024");
        }

        // Obtener nombre de categoría sanitizado
        $stmt = $pdo->prepare("SELECT nombre FROM tipos WHERE prefijo = :prefijo");
        $stmt->execute([':prefijo' => $tipos]);
        $nombreCategoria = $stmt->fetchColumn();
        if (!$nombreCategoria) {
            throw new Exception("Error: Tipo no válido.");
        }
        $nombreSanitizado = preg_replace('/[^a-z0-9]/', '_', strtolower($nombreCategoria));

        // Generar nombre de archivo según convención
        $nombreBase = "{$tipos}_{$numero}_{$anno}";
        $nombreArchivo = "{$nombreBase}_MDNCH.pdf"; // Sin subir el PDF

        // Generar ruta del enlace (sin crear carpetas)
        $linkParaBD = "archivos/{$nombreSanitizado}/{$anno}/{$nombreArchivo}";

        $pdo->beginTransaction();

        // Insertar en DOCUMENTOS
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

        // Insertar en MANTENIMIENTO
        $documento_id = $pdo->lastInsertId();
        $sqlMantenimiento = "INSERT INTO mantenimiento 
            (documento_id, accion, fecha, descripcion, link) 
            VALUES (:documento_id, 'Subida', NOW(), :descripcion, :link)";

        $stmt = $pdo->prepare($sqlMantenimiento);
        $stmt->execute([
            ':documento_id' => $documento_id,
            ':descripcion' => $descripcion,
            ':link' => $linkParaBD // Enlace generado automáticamente
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

