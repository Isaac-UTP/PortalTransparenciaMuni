<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../../login/login.html'); // Ajusta la ruta según tu estructura
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/img/logo_white.ico" type="image/x-icon">
    <title>Confirmación</title>
    <style>
        body {
            background-color: #edfbd8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .confirmation-box {
            background-color: #99dd73;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .confirmation-box h1 {
            margin: 0;
            color: #fff;
        }
    </style>
    <script>
        setTimeout(function () {
            window.location.href = "<?= $_GET['redirect'] ?? 'indexAdmin.php' ?>";
        }, 3000);
    </script>
</head>

<body>
    <div class="confirmation-box">
        <h1>✅ Operación exitosa</h1>
        <p>Serás redirigido en 5 segundos...</p>
    </div>
</body>

</html>
</div>