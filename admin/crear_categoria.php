<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /PORTALTRANSPARENCIAMUNI/login/login.html');
    exit();
}

require_once __DIR__ . '/../connection/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $prefijo = strtoupper(trim($_POST['prefijo'] ?? '')); // Normalizar prefijo

    // Validar campos requeridos
    if (empty($nombre) || empty($prefijo)) {
        die("Error: Nombre y prefijo son obligatorios.");
    }

    // Validar formato del prefijo (solo letras, 2-5 caracteres)
    if (!preg_match('/^[A-Z]{2,5}$/', $prefijo)) {
        die("Error: El prefijo debe contener 2-5 letras mayúsculas.");
    }

    try {
        $pdo->beginTransaction();

        // Insertar categoría
        $sql = "INSERT INTO tipos (codigo, nombre, prefijo, estado) 
                VALUES (:codigo, :nombre, :prefijo, 'activo')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigo,
            ':nombre' => $nombre,
            ':prefijo' => $prefijo
        ]);

        // Crear directorio
        $carpeta = "../uploads/$prefijo";
        if (!file_exists($carpeta)) {
            if (!mkdir($carpeta, 0755, true)) {
                throw new Exception("Error al crear la carpeta.");
            }
        }

        $pdo->commit();
        header("Location: categoria.php?success=1");
        exit();

    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Error en base de datos: " . $e->getMessage());
    } catch (Exception $e) {
        $pdo->rollBack();
        die($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link rel="icon" href="../public/img/logo_white.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../public/css/crear_categoria.css">
</head>

<body>
    <?php include_once '../templates/navbarAdmin.php'; ?>
    <div class="content">
        <div class="container">
            <h1>Crear Categoría</h1>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código de la Categoría:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" required>
                </div>
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
                    <a type="button" href="indexAdmin.php" class="btn btn-warning">Volver al Inicio</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>