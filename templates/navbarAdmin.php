<!-- filepath: /C:/xampp/htdocs/prueba/templates/navbarAdmin.php -->
<style>
    .sidebar {
        width: 250px;
        background-color: #F9F9F9;
        color: white;
        padding: 15px;
        height: 100vh;
        position: fixed;
        border-right: 2px solid #D1D1D1;
        /* Agregar borde gris claro */
    }

    .sidebar h2 {
        color: white;
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar .nav-link {
        color: black;
        text-decoration: none;
        padding: 10px;
        display: block;
    }

    .sidebar .nav-link:hover {
        background-color: #FFC107;
        border-radius: 5px;
        /* Añadir bordes redondeados */
    }

    .content {
        margin-left: 250px;
        /* Ajusta el margen izquierdo para que el contenido no quede oculto */
        padding: 20px;
        /* Añadir relleno */
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
            <a class="nav-link" href="indexAdmin.php"><i class="fa-solid fa-indent"></i> Inicio</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="categoriaDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-table-list"></i> Categoría
            </a>
            <ul class="dropdown-menu" aria-labelledby="categoriaDropdown">
                <li><a class="dropdown-item" href="crear_categoria.php"><i class="fa-solid fa-plus"></i> Crear
                        Categoría</a></li>
                <li><a class="dropdown-item" href="categoria.php"><i class="fa-solid fa-eye"></i> Ver Categorías</a>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="documentoDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-file"></i> Documento
            </a>
            <ul class="dropdown-menu" aria-labelledby="documentoDropdown">
                <li><a class="dropdown-item" href="subir_documento.php"><i class="fa-solid fa-file-arrow-up"></i> Subir
                        Documento</a></li>
                <li><a class="dropdown-item" href="VerDocumentos.php"><i class="fa-solid fa-eye"></i> Ver Documentos</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="usuarios.php"><i class="fa-solid fa-users"></i> Usuarios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../login/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
        </li>
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>