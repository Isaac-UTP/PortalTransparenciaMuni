<!-- filepath: /c:/xampp/htdocs/PortalTransparenciaMuni/public/navbarAdmin.php -->
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
</style>

<div class="sidebar">
    <h2>Admin Dashboard</h2>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Inicio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="subir_documento.php">Subir Documento</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="crear_categoria.php">Crear Categoría</a>
        </li>
    </ul>
</div>

<div class="content">
    <!-- Aquí va el contenido de la página -->
</div>