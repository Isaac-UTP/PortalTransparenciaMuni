<!-- filepath: /C:/xampp/htdocs/PortalTransparenciaMuni/templates/navbarAdmin.php -->
<style>
    /* Reset y fuente */
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding-top: 0 !important;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        background-color: #fff;
        border-right: 1px solid #ddd;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px 15px;
        box-shadow: 2px 0 6px rgba(0, 0, 0, 0.03);
        left: 0;
        top: 0;
        overflow-y: auto;
        z-index: 1000;
    }

    /* Logo */
    .sidebar .logo {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 30px;
    }

    /* Navegación */
    .nav-section {
        flex-grow: 1;
    }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        color: #333;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: background 0.2s;
    }

    .nav-item:hover {
        background-color: #f2f2f2;
    }

    .nav-item i {
        margin-right: 10px;
        color: #555;
    }

    /* Submenú */
    .submenu {
        padding-left: 25px;
        font-size: 0.95em;
        color: #666;
    }

    /* Footer usuario */
    .user-footer {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #eee;
        text-align: center;
        font-size: 0.9em;
        color: #666;
    }

    .logout-btn {
        margin-top: 10px;
        padding: 8px 12px;
        background-color: #ffefef;
        color: #d33;
        border: 1px solid #f5c2c2;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        transition: background 0.2s;
    }

    .logout-btn:hover {
        background-color: #ffdede;
    }

    /* Contenido principal - Mantenido del código original */
    .content {
        margin-left: 250px;
        padding: 20px;
        margin-top: 0;
    }

    /* Estilos para dropdown - Mantenidos del código original */
    .dropdown-menu {
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-top: -5px;
        margin-left: 0;
    }

    .dropdown-item {
        color: #333;
        padding: 8px 15px;
        white-space: nowrap;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-toggle::after {
        vertical-align: middle;
        margin-left: 0.5rem;
    }
     /* Estilo específico para los enlaces de la barra lateral */
    .nav-link[href="../admin/indexAdmin.php"],
    .nav-link[href="../admin/usuarios.php"],
    .nav-link[aria-controls="documentoDropdown"],
    .nav-link[aria-controls="categoriaDropdown"] {
        color: #555555 !important;
    }

</style>

<div class="sidebar">
    <img src="../public/img/logoOficial.png" alt="Logo" width="210" height="70">

    <ul class="nav flex-column nav-section">
        <li class="nav-item">
            <a class="nav-link" href="../admin/indexAdmin.php">
                <i class="fa-solid fa-house"></i> Inicio
            </a>
        </li>

        <!-- Menú Categorías -->
        <li class="nav-item dropdown nav-item">
            <a class="nav-link dropdown-toggle" href="#" id="categoriaDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-list"></i> Categorías
            </a>
            <ul class="dropdown-menu" aria-labelledby="categoriaDropdown">
                <li><a class="dropdown-item nav-item submenu" href="../admin/crear_categoria.php">
                        <i class="fa-solid fa-plus"></i> Nueva categoría
                    </a></li>
                <li><a class="dropdown-item nav-item submenu" href="../admin/categoria.php">
                        <i class="fa-solid fa-eye"></i> Ver categorías
                    </a></li>
            </ul>
        </li>

        <!-- Menú Documentos -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="documentoDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-file"></i> Documentos
            </a>
            <ul class="dropdown-menu" aria-labelledby="documentoDropdown">
                <li><a class="dropdown-item" href="../admin/subir_documento.php">
                        <i class="fa-solid fa-upload"></i> Subir documento
                    </a></li>
                <li><a class="dropdown-item" href="../admin/VerDocumentos.php">
                        <i class="fa-solid fa-list"></i> Ver documentos
                    </a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="../admin/usuarios.php">
                <i class="fa-solid fa-users"></i> Usuarios
            </a>
        </li>
    </ul>

    <!-- Sección de usuario -->
    <div class="user-info user-footer">
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
<!-- Scripts REQUERIDOS para el funcionamiento de los dropdowns -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>