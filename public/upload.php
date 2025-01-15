<?php
require_once '../connection/db.php';
//Los documentos que tengan el mismo nombre y ya esten en la base de datos no se subiran de nuevo y se ignorara la subida
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

        // Verificar el tipos MIME del archivo
        if (in_array($filetype, $allowed)) {
            // Verificar el tamaño del archivo - 5MB máximo
            $maxsize = 5 * 1024 * 1024;
            if ($filesize > $maxsize) {
                die("Error: El tamaño del archivo es mayor que el límite permitido.");
            }

            // Verificar si el archivo ya existe antes de subirlo
            $uploadDir = "../uploads/";
            $rutaArchivo = $uploadDir . $filename;
            if (file_exists($rutaArchivo)) {
                die("Error: El archivo ya existe en el servidor.");
            } else {
                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)) {
                    // Insertar en la base de datos
                    $tipos = $_POST['tipos'] ?? null;
                    $anno = $_POST['anno'] ?? null;
                    $numero = $_POST['numero'] ?? null;
                    $descripcion = $_POST['descripcion'] ?? null;
                    $link = $rutaArchivo;  // Ruta del archivo subido

                    // Validar los datos antes de insertarlos
                    if (!$tipos || !$anno || !$descripcion || !$numero) {
                        die("Error: Todos los campos son obligatorios.");
                    }

                    // Verificar si el año existe en la tabla annos
                    $sql = "SELECT COUNT(*) FROM annos WHERE anno = :anno";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':anno', $anno);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();

                    if ($count == 0) {
                        // Insertar el año en la tabla annos
                        $sql = "INSERT INTO annos (anno) VALUES (:anno)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':anno', $anno);
                        $stmt->execute();
                    }

                    // Insertar el documento en la tabla documentos
                    $sql = "INSERT INTO documentos (tipos, anno, numero, descripcion, link)
                            VALUES (:tipos, :anno, :numero, :descripcion, :link)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':tipos', $tipos);
                    $stmt->bindParam(':anno', $anno);
                    $stmt->bindParam(':numero', $numero);
                    $stmt->bindParam(':descripcion', $descripcion);
                    $stmt->bindParam(':link', $link);

                    if ($stmt->execute()) {
                        echo "El archivo fue subido exitosamente y registrado en la base de datos.";
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