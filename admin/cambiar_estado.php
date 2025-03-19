<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /PORTALTRANSPARENCIAMUNI/login/login.html');
    exit();
}

require_once __DIR__ . '/../connection/db.php';

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $estado = $_GET['estado'];

    $sql = "UPDATE tipos SET estado = :estado WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: categoria.php');
        exit();
    } else {
        echo "Error al cambiar el estado de la categoría.";
    }
} else {
    echo "Datos incompletos.";
}
?>