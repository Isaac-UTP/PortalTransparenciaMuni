<?php
//Archivo de Conexión a la BD
$host = "localhost";
$dbname = "transparenciamun_web";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //que salga un mensaje que luego desaparece que se conecto correctamente con la base de datos
    //echo "Conexión exitosa a la base de datos";
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>