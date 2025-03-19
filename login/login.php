<?php
session_start();
require_once '../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Comparación en texto plano

    $sql = "SELECT * FROM usuarios WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password); // Sin hash

    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $_SESSION['username'] = $username;
        header('Location: ../admin/indexAdmin.php');
        exit(); // ¡Importante para evitar ejecución adicional!
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>