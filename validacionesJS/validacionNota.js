document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const alumnoSelect = document.getElementById('alumno');
    const materiaSelect = document.getElementById('materia');
    const notaInput = document.getElementById('nota');

    form.addEventListener('submit', function(event) {
        let valid = true;

        if (alumnoSelect.value === "") {
            alert("Por favor, seleccione un alumno.");
            valid = false;
        }

        if (materiaSelect.value === "") {
            alert("Por favor, seleccione una materia.");
            valid = false;
        }

        const nota = parseFloat(notaInput.value);
        if (isNaN(nota) || nota < 0 || nota > 10) {
            alert("Por favor, ingrese una nota válida entre 0 y 10.");
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });
});
