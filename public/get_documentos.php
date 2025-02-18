<?php
require_once '../connection/db.php';

// Obtener los parámetros de búsqueda
$searchKeyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$searchYear = isset($_GET['anno']) ? $_GET['anno'] : '';

// Construir la consulta SQL
$sql = "
    SELECT d.id, t.nombre AS tipos, d.anno, d.numero, m.descripcion, m.link 
    FROM documentos d
    INNER JOIN tipos t ON d.tipo = t.prefijo
    LEFT JOIN mantenimiento m ON d.id = m.documento_id
    WHERE m.descripcion LIKE :keyword";

$params = [':keyword' => '%' . $searchKeyword . '%'];

if (!empty($searchYear)) {
    $sql .= " AND d.anno = :anno";
    $params[':anno'] = $searchYear;
}

$sql .= " ORDER BY d.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los documentos en formato JSON
header('Content-Type: application/json');
echo json_encode($documentos);
?>