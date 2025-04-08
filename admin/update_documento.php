<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /PORTALTRANSPARENCIAMUNI/login/login.html');
    exit();
}

require_once __DIR__ . '/../connection/db.php';

if (!isset($_POST['id'])) {
    die("Error: ID de documento no proporcionado.");
}

$documento_id = $_POST['id'];

try {
    $pdo->beginTransaction();

    // 1. Obtener datos actuales del documento
    $sqlDocumento = "SELECT tipo, anno, numero FROM documentos WHERE id = :id";
    $stmtDocumento = $pdo->prepare($sqlDocumento);
    $stmtDocumento->execute([':id' => $documento_id]);
    $documentoActual = $stmtDocumento->fetch(PDO::FETCH_ASSOC);

    // 2. Determinar nuevos valores
    $nuevoTipo = $_POST['tipos'];
    $nuevoAnno = $_POST['anno'];
    $nuevoNumero = $_POST['numero'];
    $nuevaDescripcion = $_POST['descripcion'];

    // Obtener nombre de la nueva categoría
    $stmt = $pdo->prepare("SELECT nombre FROM tipos WHERE prefijo = :prefijo");
    $stmt->execute([':prefijo' => $nuevoTipo]);
    $nombreCategoria = $stmt->fetchColumn();
    // Sanitizar el nombre de la categoría
    $nombreSanitizado = preg_replace('/[^a-z0-9]/', '_', strtolower($nombreCategoria)); // Guiones bajos

    // Ruta actualizada
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/archivos/archivos/$nombreSanitizado/$nuevoAnno/";

    // 3. Manejar archivo si se sube uno nuevo
    $nuevaRutaArchivo = null;
    if (!empty($_FILES['archivo']['name'])) {
        $filename = $_FILES['archivo']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);


        // Construir nombre según convención (AC_001_2023_MDNCH.pdf)
        $nombreBase = "{$nuevoTipo}_{$nuevoNumero}_{$nuevoAnno}"; // <- Guiones bajos
        $nuevoNombreArchivo = "{$nombreBase}_MDNCH.pdf"; // <- Agregar sufijo

        // Crear directorio si no existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Eliminar archivo anterior si existe
        $sqlMantenimiento = "SELECT link FROM mantenimiento WHERE documento_id = :id ORDER BY id DESC LIMIT 1";
        $stmtMantenimiento = $pdo->prepare($sqlMantenimiento);
        $stmtMantenimiento->execute([':id' => $documento_id]);
        $archivoAnterior = $stmtMantenimiento->fetchColumn();

        if ($archivoAnterior && file_exists($_SERVER['DOCUMENT_ROOT'] . "/PORTALTRANSPARENCIAMUNI/public/{$archivoAnterior}")) {
            unlink($_SERVER['DOCUMENT_ROOT'] . "/PORTALTRANSPARENCIAMUNI/public/{$archivoAnterior}");
        }

        // Mover nuevo archivo
        $rutaCompleta = $uploadDir . $nuevoNombreArchivo;

        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaCompleta)) {
            throw new Exception("Error al subir el archivo.");
        }

        $nuevaRutaArchivo = "archivo/{$nombreSanitizado}/{$nuevoAnno}/{$nuevoNombreArchivo}";
    }

    // 4. Actualizar documento en la base de datos
    $sqlUpdateDocumento = "UPDATE documentos SET 
        tipo = :tipo,
        anno = :anno,
        numero = :numero,  -- Cambiado a minúscula
        descripcion = :descripcion
        WHERE id = :id";

    $stmt = $pdo->prepare($sqlUpdateDocumento);
    $stmt->execute([
        ':tipo' => $nuevoTipo,
        ':anno' => $nuevoAnno,
        ':numero' => $nuevoNumero,
        ':descripcion' => $nuevaDescripcion,
        ':id' => $documento_id
    ]);

    // 5. Actualizar mantenimiento si hay nuevo archivo
    $sqlMantenimiento = "INSERT INTO mantenimiento 
        (documento_id, accion, fecha, descripcion, link) 
        VALUES (:documento_id, 'Actualización', NOW(), :descripcion, :link)";

    $stmt = $pdo->prepare($sqlMantenimiento);
    $stmt->execute([
        ':documento_id' => $documento_id,
        ':descripcion' => $nuevaDescripcion,
        ':link' => $nuevaRutaArchivo ?? $archivoAnterior // Mantiene el link anterior si no hay cambio
    ]);

    $pdo->commit();
    header("Location: confirmacion.php?redirect=VerDocumentos.php");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
?>
