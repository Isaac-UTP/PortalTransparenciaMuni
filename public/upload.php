<?php
require_once '../connection/db.php';

// Los documentos que tengan el mismo nombre y ya estén en la base de datos no se subirán de nuevo y se ignorará la subida
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

            // Obtener los datos del formulario
            $tipos = $_POST['tipos'] ?? null;
            $anno = $_POST['anno'] ?? null;
            $numero = $_POST['numero'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;

            if (!$tipos || !$anno || !$numero || !$descripcion) {
                die("Error: Todos los campos son obligatorios.");
            }

            // Crear la carpeta si no existe
            $uploadDir = "../uploads/$tipos/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Verificar si el archivo ya existe antes de subirlo
            $rutaArchivo = $uploadDir . $filename;
            if (file_exists($rutaArchivo)) {
                echo "El archivo ya existe y no se ha subido de nuevo.";
            } else {
                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)) {
                    // Insertar en la base de datos
                    $link = $rutaArchivo;  // Ruta del archivo subido

                    // Insertar el documento en la tabla documentos
                    $sql = "INSERT INTO documentos (tipo, anno, numero, fecha, descripcion)
                            VALUES (:tipo, :anno, :numero, NOW(), :descripcion)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':tipo', $tipos);
                    $stmt->bindParam(':anno', $anno);
                    $stmt->bindParam(':numero', $numero);
                    $stmt->bindParam(':descripcion', $descripcion);

                    if ($stmt->execute()) {
                        $documento_id = $pdo->lastInsertId();

                        // Insertar en la tabla mantenimiento
                        $sql = "INSERT INTO mantenimiento (documento_id, accion, fecha, descripcion, link)
                                VALUES (:documento_id, 'Subida', NOW(), :descripcion, :link)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':documento_id', $documento_id);
                        $stmt->bindParam(':descripcion', $descripcion);
                        $stmt->bindParam(':link', $link);

                        if ($stmt->execute()) {
                            echo "El archivo fue subido exitosamente y registrado en la base de datos.";
                        } else {
                            echo "Error al guardar los datos en la base de datos.";
                        }
                    } else {
                        echo "Error al guardar los datos en la base de datos.";
                    }
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