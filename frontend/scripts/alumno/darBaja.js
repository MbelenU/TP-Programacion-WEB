document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('#darBaja');

    buttons.forEach(button => {
        button.addEventListener('click', function(event) {
            const solicitudItem = event.target.closest('li');
            const solicitudId = solicitudItem.getAttribute('data-solicitud-id'); 


            const formData = new FormData();
            formData.append('solicitud_id', solicitudId);

            fetch(`/TP-Programacion-WEB/controllers/AlumnoController.php?darBaja`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageContainer = document.getElementById('message-container');
                let alertMessage = '';
                if (data.success) {
                    alertMessage = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        Postulacion eliminada.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                     </div>`;
                    solicitudItem.remove();
                } else {
                    alertMessage = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Hubo un error al eliminar la postulacion. Inténtalo de nuevo.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                     </div>`;
                }

                messageContainer.innerHTML = alertMessage;
            })
            .catch(error => {
                console.error('Error al procesar la postulacion:', error);
                const messageContainer = document.getElementById('message-container');
                const alertMessage = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        Hubo un problema con la postulacion. Inténtalo más tarde.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                     </div>`;
                messageContainer.innerHTML = alertMessage;
            });
        });
    });
});
