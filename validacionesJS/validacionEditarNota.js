// validacionEditarNota.js

document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.querySelector('form');
    const notaInput = document.getElementById('nota');
    
    formulario.addEventListener('submit', function(event) {
        let nota = parseFloat(notaInput.value);

        // Validar que la nota esté dentro del rango permitido
        if (isNaN(nota) || nota < 0 || nota > 10) {
            alert("La nota debe estar entre 0 y 10.");
            event.preventDefault(); // Evita el envío del formulario
            return false;
        }
    });
});
