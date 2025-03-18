<?php
session_start();
?>
<!-- filepath: /C:/xampp/htdocs/prueba/templates/navbarAdmin.php -->
<style>
    .sidebar {
        width: 250px;
        background-color: #F9F9F9;
        padding: 15px;
        height: 100vh;
        position: fixed;
        border-right: 2px solid #D1D1D1;
        display: flex;
        flex-direction: column;
    }

    .sidebar .nav-link {
        color: #333;
        text-decoration: none;
        padding: 10px;
        display: block;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover {
        background-color: #FFC107;
        border-radius: 5px;
    }

    .content {
        margin-left: 250px;
        padding: 20px;
    }

    .sidebar img {
        display: block;
        margin: 0 auto 20px;
        max-width: 100%;
        height: auto;
    }

    .dropdown-menu {
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-left: 0.5rem;
    }

    .dropdown-item {
        color: #333;
        padding: 8px 15px;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .user-info {
        margin-top: auto;
        padding: 15px 0;
    }

    .user-card {
        background: #fff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="sidebar">
    <img src="../public/img/logoOficial.png" alt="Logo" width="250" height="70">

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="indexAdmin.php">
                <i class="fa-solid fa-house"></i> Inicio
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="categoriaDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-list"></i> Categorías
            </a>
            <ul class="dropdown-menu" aria-labelledby="categoriaDropdown">
                <li><a class="dropdown-item" href="crear_categoria.php">
                        <i class="fa-solid fa-plus"></i> Nueva categoría
                    </a></li>
                <li><a class="dropdown-item" href="categoria.php">
                        <i class="fa-solid fa-eye"></i> Ver categorías
                    </a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="documentoDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-file"></i> Documentos
            </a>
            <ul class="dropdown-menu" aria-labelledby="documentoDropdown">
                <li><a class="dropdown-item" href="subir_documento.php">
                        <i class="fa-solid fa-upload"></i> Subir documento
                    </a></li>
                <li><a class="dropdown-item" href="VerDocumentos.php">
                        <i class="fa-solid fa-list"></i> Ver documentos
                    </a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="usuarios.php">
                <i class="fa-solid fa-users"></i> Usuarios
            </a>
        </li>
    </ul>

    <!-- Sección de usuario -->
    <div class="user-info">
        <div class="user-card">
            <?php if (isset($_SESSION['username'])): ?>
                <p class="mb-1"><i class="fa-solid fa-user"></i>
                    <?= htmlspecialchars($_SESSION['username']) ?>
                </p>
                <a href="../login/logout.php" class="btn btn-danger btn-sm w-100">
                    <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
                </a>
            <?php else: ?>
                <p class="text-muted mb-1">No autenticado</p>
                <a href="../login/login.html" class="btn btn-primary btn-sm w-100">
                    <i class="fa-solid fa-right-to-bracket"></i> Iniciar sesión
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>