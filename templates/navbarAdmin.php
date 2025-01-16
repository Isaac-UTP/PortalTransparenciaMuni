<!-- filepath: /c:/xampp/htdocs/PortalTransparenciaMuni/public/navbar.php -->
<style>
    .navbar-brand-container {
        background-color: #000;
        /* Fondo negro */
        padding: 10px;
        /* Padding opcional */
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="bg-dark p-1 rounded">
            <a class="navbar-brand" href="index.php" title="Inicio">
                <img src="img/logo_white.ico" alt="Logo del sitio" width="24" height="24"
                    class="d-inline-block align-text-top">
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php" title="Inicio">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="subir_documento.php" title="Subir Documento">Subir Documento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="crear_categoria.php" title="Crear Categoría">Crear Categoría</a>
                </li>
            </ul>
        </div>
    </div>
</nav>