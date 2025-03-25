<?php
session_start();
require_once '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Texto plano

    $sql = "INSERT INTO usuarios (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password); // Almacena en texto plano

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        header('Location: ../admin/indexAdmin.php');
        exit();
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>