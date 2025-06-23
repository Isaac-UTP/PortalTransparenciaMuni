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
    <link rel="stylesheet" href="../public/css/usuarios.css">
</head>

<body>
    <?php include_once '../templates/navbarAdmin.php'; ?>
    <div class="content">
        <div class="container mt-5">
            <h2>Usuarios</h2>
            <div class="row g-4">
                <?php foreach ($usuarios as $usuario): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card shadow-sm user-card h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa-solid fa-user fa-lg me-2" style="color: #161717;"></i>
                                        <span class="fw-semibold"><?= htmlspecialchars($usuario['username']) ?></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-key fa-lg me-2" style="color: #6c757d;"></i>
                                        <?php if ($usuario['username'] == $username): ?>
                                            <div class="password-container flex-grow-1">
                                                <input type="password" value="<?= htmlspecialchars($usuario['password']) ?>"
                                                    class="password-field form-control form-control-sm d-inline-block w-auto"
                                                    readonly>
                                                <button class="btn btn-outline-secondary btn-sm toggle-password ms-2"
                                                    type="button" onclick="togglePassword(this)">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">********</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function togglePassword(button) {
            const input = button.previousElementSibling;
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

    <link rel="stylesheet" href="../public/css/usuarios.css">
</body>

</html>