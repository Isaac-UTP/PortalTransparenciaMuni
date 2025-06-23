
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    document.getElementById('tipo').addEventListener('change', function () {
        form.submit(); // conserva los demás filtros al cambiar tipo
    });

    document.getElementById('anio').addEventListener('change', function () {
        form.submit(); // conserva los demás filtros al cambiar año
    });

    document.getElementById('keyword').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            form.submit(); // permite filtrar por palabra clave sin perder tipo/año
        }
    });
});
