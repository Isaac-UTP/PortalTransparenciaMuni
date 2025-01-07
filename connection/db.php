<?php
//Archivo de Conexión a la BD
$host = "localhost";
$dbname = "nombre_base_datos";
$user = "usuario";
$password = "contraseña";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>
