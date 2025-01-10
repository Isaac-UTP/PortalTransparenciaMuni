<?php
// Initialize the session
session_start();

// coneccion con la base de datos
require_once "../connection/db.php";

// Include config file
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si el archivo fue subido sin errores
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $allowed = ['pdf' => 'application/pdf'];
        $filename = $_FILES['archivo']['name'];
        $filetype = $_FILES['archivo']['type'];
        $filesize = $_FILES['archivo']['size'];

        // Verificar la extensión del archivo
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die("Error: Por favor seleccione un formato de archivo válido.");
        }

        // Verificar el tipo MIME del archivo
        if (in_array($filetype, $allowed)) {
            // Verificar el tamaño del archivo - 5MB máximo
            $maxsize = 5 * 1024 * 1024;
            if ($filesize > $maxsize) {
                die("Error: El tamaño del archivo es mayor que el límite permitido.");
            }

            // Verificar si el archivo ya existe antes de subirlo
            if (file_exists("upload/" . $filename)) {
                echo "El archivo ya existe y no se ha subido de nuevo.";
            } else {
                if (move_uploaded_file($_FILES['archivo']['tmp_name'], "upload/" . $filename)) {
                    echo "El archivo fue subido exitosamente.";
                } else {
                    die("Error: Hubo un problema al subir su archivo. Por favor intente de nuevo.");
                }
            }
        } else {
            die("Error: Hubo un problema al subir su archivo. Por favor intente de nuevo.");
        }
    } else {
        die("Error: " . $_FILES['archivo']['error']);
    }
}
?>
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
            <select name="tipo" id="tipo" required>
                <option value="">--TIPOS--</option>
                <?php
                // Obtener tipos desde la base de datos
                $sql = "SELECT * FROM tipos";
                $stmt = $pdo->query($sql);
                $tipos = $stmt->fetchAll();

                foreach ($tipos as $tipo) {
                    echo "<option value='{$tipo['id']}'>{$tipo['nombre']}</option>";
                }
                ?>
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
