<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="categoria" placeholder="Categoría" required>
    <input type="number" name="anio" placeholder="Año" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="file" name="archivo" required>
    <button type="submit">Subir</button>
</form>
<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = $_POST['categoria'];
    $anio = $_POST['anio'];
    $descripcion = $_POST['descripcion'];
    $archivo = $_FILES['archivo'];

    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = uniqid() . "_" . basename($archivo['name']);
        $rutaArchivo = "../public/uploads/" . $nombreArchivo;
        move_uploaded_file($archivo['tmp_name'], $rutaArchivo);

        $stmt = $pdo->prepare("INSERT INTO documentos (categoria, anio, nombre_archivo, descripcion) VALUES (:categoria, :anio, :nombre_archivo, :descripcion)");
        $stmt->execute([
            ':categoria' => $categoria,
            ':anio' => $anio,
            ':nombre_archivo' => $nombreArchivo,
            ':descripcion' => $descripcion,
        ]);

        echo "Archivo subido exitosamente.";
    } else {
        echo "Error al subir el archivo.";
    }
}
?>
