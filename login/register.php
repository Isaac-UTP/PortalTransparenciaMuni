<?php
session_start();
require_once '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Registrar:
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        // Validar:
        $sql = "SELECT password FROM usuarios WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $hashedPasswordFromDB = $stmt->fetchColumn();

        if (password_verify($password, $hashedPasswordFromDB)) {
            // Acceso concedido
            // Establecer la sesión con el nombre de usuario
            $_SESSION['username'] = $username;
            // Redirigir a indexAdmin.php
            header('Location: /PORTALTRANSPARENCIAMUNI/admin/indexAdmin.php');
            exit();
        } else {
            echo "Error al validar el usuario.";
        }
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>