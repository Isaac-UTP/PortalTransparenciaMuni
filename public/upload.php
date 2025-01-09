<!--Falta ajustar aca-->
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="tipos" placeholder="tipos" required>
    <input type="number" name="anno" placeholder="Año" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="file" name="archivo" required>
    <button type="submit">Subir</button>
</form>

<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipos = $_POST['tipos'];
    $anio = $_POST['anio'];
    $descripcion = $_POST['descripcion'];
    $archivo = $_FILES['archivo'];

    // Verificar si hubo un error al subir el archivo
    if ($archivo['error'] === UPLOAD_ERR_OK) {
        // Crear el nombre único para el archivo
        $nombreArchivo = uniqid() . "_" . basename($archivo['name']);

        // Definir la ruta al directorio `prueba\uploads`
        $directorioUploads = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
        
        // Crear el directorio si no existe
        if (!is_dir($directorioUploads)) {
            mkdir($directorioUploads, 0755, true);
        }

        // Ruta completa al archivo
        $rutaArchivo = $directorioUploads . $nombreArchivo;

        // Mover el archivo subido al directorio `uploads`
        if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
            // Insertar los datos en la base de datos
            $stmt = $pdo->prepare("INSERT INTO documentos (tipos, anio, nombre_archivo, descripcion) VALUES (:tipos, :anio, :nombre_archivo, :descripcion)");
            $stmt->execute([
                ':tipos' => $tipos,
                ':anio' => $anio,
                ':nombre_archivo' => $nombreArchivo,
                ':descripcion' => $descripcion,
            ]);

            echo '<script>alert("Archivo subido exitosamente."); window.location.href="index.php";</script>';
        } else {
            echo '<script>alert("Error al mover el archivo al directorio de destino.");</script>';
        }
    } else {
        echo '<script>alert("Error al subir el archivo. Código de error: ' . $archivo['error'] . '");</script>';
    }
}
?>
