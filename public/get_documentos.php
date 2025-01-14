<?php
require_once '../connection/db.php';

// Obtener los documentos desde la base de datos
$sql = "
    SELECT d.id, t.nombre AS tipos, d.anno, d.descripcion, d.numero, d.link 
    FROM documentos d
    INNER JOIN tipos t ON d.tipos = t.prefijo
    ORDER BY d.id DESC";
$stmt = $pdo->query($sql);
$documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los documentos en formato JSON
header('Content-Type: application/json');
echo json_encode($documentos);
?>