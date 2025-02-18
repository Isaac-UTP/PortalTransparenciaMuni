<?php
session_start();
require_once '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO usuarios (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        // Establecer la sesión con el nombre de usuario
        $_SESSION['username'] = $username;
        // Redirigir a indexAdmin.php
        header('Location: ../public/indexAdmin.php');
        exit();
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>