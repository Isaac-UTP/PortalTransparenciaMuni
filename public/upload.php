<!--Falta ajustar aca-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir archivo</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Subir archivo</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
                <option value="Ordenanza">Ordenanza</option>
                <option value="Resolución">Resolución</option>
                <option value="Decreto">Decreto</option>
            </select>
        </div>
        <div>
            <label for="anno">Año:</label>
            <input type="number" name="anno" id="anno" required>
        </div>
        <div>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required></textarea>
        </div>
        <div>
            <label for="archivo">Archivo:</label>
            <input type="file" name="archivo" id="archivo" required>
        </div>
        <button type="submit">Subir archivo</button>
    </form>
</body>
</html>

<?php
require_once '../includes/db.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipos = $_POST['tipo'];
    $anno = $_POST['anno'];
    $descripcion = $_POST['descripcion'];
    $numero = uniqid() . "_" . basename($_FILES['archivo']['name']);
    $archivo = $_FILES['archivo'];
    $fecha = date('Y-m-d H:i:s');

    // Verificar si hubo un error al subir el archivo
    if ($archivo['error'] === UPLOAD_ERR_OK) {
        // Crear el nombre único para el archivo
        $numero = uniqid() . "_" . basename($archivo['name']);

        // Definir la ruta al directorio `prueba\uploads`
        $directorioUploads = '../uploads/';

        // Crear el directorio si no existe
        if (!is_dir($directorioUploads)) {
            mkdir($directorioUploads, 0755, true);
        }

        // Ruta completa al archivo
        $rutaArchivo = $directorioUploads . $numero;

        // Mover el archivo subido al directorio `uploads`
        if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
            // Insertar los datos en la base de datos
            $sql = "INSERT INTO documentos (tipo, anno, descripcion, numero, fecha) 
                    VALUES (:tipo, :anno, :descripcion, :numero, :fecha)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':tipo', $tipos);
            $stmt->bindParam(':anno', $anno);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':numero', $numero);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->execute();

            // Redireccionar al inicio
            echo '<script>alert("Archivo subido exitosamente."); window.location.href="index.php";</script>';
        } else {
            // Error al mover el archivo
            echo '<script>alert("Error al mover el archivo al directorio de destino.");</script>';
        }
    } else {
        // Error al subir el archivo
        echo '<script>alert("Error al subir el archivo. Código de error: ' . $archivo['error'] . '");</script>';
    }
}
?>
