<?php
session_start();
require_once '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $_SESSION['username'] = $username;
        header('Location: ../public/indexAdmin.php');
    } else {
        echo "Nombre de usuario o contraseña incorrectos.";
    }
}
?>