// Script para manejar el modal
document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('uploadModal').style.display = 'block';
});

document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('uploadModal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target === document.getElementById('uploadModal')) {
        document.getElementById('uploadModal').style.display = 'none';
    }
});
