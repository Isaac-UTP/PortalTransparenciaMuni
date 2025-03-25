<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.html");
    exit();
}
?>
<?php
require_once '../connection/db.php';

$username = $_SESSION['username'];

$sql = "SELECT username, password FROM usuarios";
$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="icon" href="../public/img/logo_white.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</head>

<body>
    <?php include_once '../templates/navbarAdmin.php'; ?>
    <div class="content">
        <div class="container mt-5">
            <h2>Usuarios</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Contraseña</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['username']) ?></td>
                            <td>
                                <?php if ($usuario['username'] == $username): ?>
                                    <div class="password-container">
                                        <input type="password" value="<?= htmlspecialchars($usuario['password']) ?>"
                                            class="password-field" readonly>
                                        <button class="toggle-password" onclick="togglePassword(this)">👁️</button>
                                    </div>
                                <?php else: ?>
                                    ********
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function togglePassword(button) {
            const input = button.previousElementSibling;
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

    <!-- CSS -->
    <style>
        .password-container {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .password-field {
            border: none;
            background: transparent;
            width: 100px;
            outline: none;
        }

        .toggle-password {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }
    </style>
</body>

</html>