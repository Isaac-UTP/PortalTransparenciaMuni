<!-- filepath: /C:/xampp/htdocs/prueba/templates/navbarAdmin.php -->
<style>
    .sidebar {
        width: 250px;
        background-color: #343a40;
        color: white;
        padding: 15px;
        height: 100vh;
        position: fixed;
    }
    .sidebar h2 {
        color: white;
        text-align: center;
        margin-bottom: 20px;
    }
    .sidebar .nav-link {
        color: white;
        text-decoration: none;
        padding: 10px;
        display: block;
    }
    .sidebar .nav-link:hover {
        background-color: #495057;
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
        background-color: #343a40;
        border: none;
    }
    .dropdown-item {
        color: white;
    }
    .dropdown-item:hover {
        background-color: #495057;
    }
</style>

<div class="sidebar">
    <img src="../public/img/logoOficial.png" alt="Logo" width="250" height="70">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Inicio</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="categoriaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Categoría
            </a>
            <ul class="dropdown-menu" aria-labelledby="categoriaDropdown">
                <li><a class="dropdown-item" href="crear_categoria.php">Crear Categoría</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="documentoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Documento
            </a>
            <ul class="dropdown-menu" aria-labelledby="documentoDropdown">
                <li><a class="dropdown-item" href="subir_documento.php">Subir Documento</a></li>
            </ul>
        </li>
    </ul>
</div>

<div class="content">
    <!-- Aquí va el contenido de la página -->
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>