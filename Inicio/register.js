// Esperar a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {
    const tipoUsuario = document.getElementById('tipoUsuario');
    const formAlumno = document.getElementById('formAlumno');
    const formEmpresa = document.getElementById('formEmpresa');

    // Obtener los elementos del modal
    const modalHeader = document.getElementById('modalHeader');
    const modalBody = document.getElementById('modalBody');
    const modalButton = document.getElementById('modalButton');
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));

    function mensaje (){
        // Si completó el formulario:
            // Cambiar modal a estilo de éxito
            modalHeader.classList.add('bg-success');
            modalButton.classList.add('btn-success');

            // Actualizar contenido del modal
            document.getElementById('confirmationModalLabel').textContent = "Solicitud enviada";
            modalBody.innerHTML = `Se ha enviado una petición de registro. Por favor esté atento su correo electrónico.`;

            // Mostrar el modal
            confirmationModal.show();

            // Redirigir después de cerrar el modal
            document.getElementById('confirmationModal').addEventListener('hidden.bs.modal', function () {
                window.location.href = "inicio.html";
            });
    };
    
    tipoUsuario.addEventListener('change', function() {
        const usuarioSeleccionado = tipoUsuario.value;

        // Ocultar ambos formularios al inicio
        formAlumno.classList.add('d-none');
        formEmpresa.classList.add('d-none');
        // Quita la validación al cambiar de usuario
        formEmpresa.classList.remove('was-validated');
        formAlumno.classList.remove('was-validated');

        // Mostrar el formulario correspondiente según la selección
        if (usuarioSeleccionado === 'alumno') {
            formAlumno.classList.remove('d-none');
        } else if (usuarioSeleccionado === 'empresa') {
            formEmpresa.classList.remove('d-none');
        }
    });

    // Validación de los formularios (Opcional)
    formAlumno.addEventListener('submit', function(event) {
        event.preventDefault();

        if (formAlumno.checkValidity() === false) {
            // Mostrar los mensajes de error de HTML5
            formAlumno.classList.add("was-validated");
            // Resetea el Formulario
            formAlumno.reset();
        }else{
            mensaje();
        } 
    });

    formEmpresa.addEventListener('submit', function(event) {
        event.preventDefault();

        if (formEmpresa.checkValidity() === false) {
            // Mostrar los mensajes de error de HTML5
            formEmpresa.classList.add("was-validated");
            // Resetea el Formulario
            formEmpresa.reset();
        }else{
            mensaje();
        }
        
    });

});
