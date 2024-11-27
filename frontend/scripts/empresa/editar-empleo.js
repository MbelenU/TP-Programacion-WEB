const tituloInput = document.getElementById('titulo');
const ubicacion = document.getElementById('ubicacion');
const descripcion = document.getElementById('descripcion');
const jornadaSelect = document.getElementById('jornada');
const modalidadSelect = document.getElementById('modalidad');
const guardarPublicacion = document.getElementById('guardarPublicacion');
const publicarForm = document.getElementById('publicarForm');

document.addEventListener('DOMContentLoaded', async function() {
    guardarPublicacion.addEventListener('click', async function (event) {
        const id = guardarPublicacion.getAttribute('data-empleo-id');
        event.preventDefault();
        const existingError = document.querySelector('.alert.alert-danger');
        if (existingError) {
            existingError.remove();
        }

        // Crear un objeto con solo los datos básicos
        const publicacionData = {
            titulo: tituloInput.value,
            modalidad: modalidadSelect.value,
            ubicacion: ubicacion.value,
            jornada: jornadaSelect.value,
            descripcion: descripcion.value,
        }

        // Enviar los datos a la API para guardar los cambios
        let response = await fetch(`/TP-Programacion-WEB/controllers/EmpresaController.php?editarEmpleo=${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(publicacionData)
        });

        response = await response.json();

        if(response.success) {
            window.location.href = `/TP-Programacion-WEB/frontend/views/empresa-visualizar-publicacion.php?id=${response.body}`;
        } else {
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('alert', 'alert-danger', 'mt-3');
            errorDiv.setAttribute('role', 'alert');
            errorDiv.textContent = response.error;

            const formulario = document.getElementById('publicarForm');
            formulario.insertBefore(errorDiv, formulario.firstChild);
        }

        console.log(response);
    });
});
