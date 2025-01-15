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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-label {
            font-weight: bold;
            color: #555;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
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
            <div class="modal-footer d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-success">Crear Categoría</button>
                <a type="button" href="index.php" class="btn btn-warning">Volver al Inicio</a>
            </div>
        </form>
    </div>
</body>

</html>