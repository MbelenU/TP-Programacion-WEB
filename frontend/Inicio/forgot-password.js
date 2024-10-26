document.getElementById('forgot-password-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita el envío del formulario

    // Obtener el email ingresado
    const email = document.getElementById('email').value;

    // Obtener los elementos del modal
    const modalHeader = document.getElementById('modalHeader');
    const modalBody = document.getElementById('modalBody');
    const modalButton = document.getElementById('modalButton');
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    
    if (email) {
        modalHeader.classList.remove('bg-danger');
        modalHeader.classList.add('bg-success');
        modalButton.classList.remove('btn-danger');
        modalButton.classList.add('btn-success');

        // Actualizar contenido del modal
        document.getElementById('confirmationModalLabel').textContent = "Correo enviado";
        modalBody.innerHTML = `Se ha enviado un enlace de restablecimiento a <span id="userEmail" class="fw-bold">${email}</span>. Por favor, revise su correo electrónico.`;

        // Mostrar el modal
        confirmationModal.show();

        // Redirigir después de cerrar el modal
        document.getElementById('confirmationModal').addEventListener('hidden.bs.modal', function () {
            window.location.href = "inicio.html";
        });
    } else {
        // Si el email es inválido:
        // Cambiar modal a estilo de error
        modalHeader.classList.remove('bg-success');
        modalHeader.classList.add('bg-danger');
        modalButton.classList.remove('btn-success');
        modalButton.classList.add('btn-danger');

        // Actualizar contenido del modal para error
        document.getElementById('confirmationModalLabel').textContent = "Error";
        modalBody.textContent = "Por favor, ingrese un correo electrónico válido.";

        // Mostrar el modal
        confirmationModal.show();
    }
});
