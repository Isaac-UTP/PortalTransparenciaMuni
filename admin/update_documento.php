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

    // Obtener nuevos datos
    $nuevoTipo = $_POST['tipos'];
    $nuevoAnno = $_POST['anno'];
    $nuevoNumero = $_POST['numero'];
    $nuevaDescripcion = $_POST['descripcion'];

    // Obtener nombre de la nueva categoría
    $stmt = $pdo->prepare("SELECT nombre FROM tipos WHERE prefijo = :prefijo");
    $stmt->execute([':prefijo' => $nuevoTipo]);
    $nombreCategoria = $stmt->fetchColumn();
    $nombreSanitizado = preg_replace('/[^a-z0-9]/', '_', strtolower($nombreCategoria));

    // Generar nuevo nombre de archivo
    $nombreBase = "{$nuevoTipo}_{$nuevoNumero}_{$nuevoAnno}";
    $nuevoNombreArchivo = "{$nombreBase}_MDNCH.pdf";
    $nuevaRutaArchivo = "archivos/{$nombreSanitizado}/{$nuevoAnno}/{$nuevoNombreArchivo}";

    // Actualizar documento
    $sqlUpdateDocumento = "UPDATE documentos SET 
        tipo = :tipo,
        anno = :anno,
        numero = :numero,
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

    // Actualizar mantenimiento
    $sqlMantenimiento = "INSERT INTO mantenimiento 
        (documento_id, accion, fecha, descripcion, link) 
        VALUES (:documento_id, 'Actualización', NOW(), :descripcion, :link)";

    $stmt = $pdo->prepare($sqlMantenimiento);
    $stmt->execute([
        ':documento_id' => $documento_id,
        ':descripcion' => $nuevaDescripcion,
        ':link' => $nuevaRutaArchivo // Nuevo enlace generado
    ]);

    $pdo->commit();
    header("Location: confirmacion.php?redirect=VerDocumentos.php");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
?>
