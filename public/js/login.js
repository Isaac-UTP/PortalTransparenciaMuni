document.querySelector('.toggle').addEventListener('change', function() {
    document.querySelector('.flip-card__inner').classList.toggle('flipped');
    
    // Limpiar los campos de los formularios
    document.querySelectorAll('.flip-card__form input').forEach(input => {
        input.value = '';
    });
});