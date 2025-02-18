<?php
require_once '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO usuarios (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>