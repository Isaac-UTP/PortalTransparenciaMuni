<?php
require_once '../connection/db.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $prefijo = $_POST['prefijo'] ?? '';

    if ($nombre && $prefijo) {
        $sql = "INSERT INTO tipos (nombre, prefijo) VALUES (:nombre, :prefijo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':prefijo', $prefijo);

        if ($stmt->execute()) {
            $mensaje = "Categoría creada exitosamente.";
        } else {
            $mensaje = "Error al crear la categoría.";
        }
    } else {
        $mensaje = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Crear Categoría</h1>
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Categoría:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prefijo" class="form-label">Prefijo:</label>
                <input type="text" name="prefijo" id="prefijo" class="form-control" maxlength="5" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Categoría</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">Volver al Inicio</a>
    </div>
</body>
</html>
