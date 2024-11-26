document.addEventListener('DOMContentLoaded', function() {
    // Captura todos los botones de desuscribirse del evento
    const unsubscribeButtons = document.querySelectorAll('button[data-desuscribir-id]');

    unsubscribeButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const id = this.getAttribute('data-desuscribir-id')           
            await eliminarSuscripcion(id); // Esperamos que la función async se complete
        });
    });
});

async function eliminarSuscripcion(id) {
    try {
        const response = await fetch(`/TP-Programacion-WEB/controllers/AlumnoController.php?borrarSuscripcion=`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                id: id
            })
        });

        const data = await response.json(); // Esperamos la respuesta

        if (data.success) {
            console.log('Te has desuscrito del evento con éxito');
            // Eliminar el evento solo de la lista de suscripciones
            const eventoElement = document.querySelector(`[data-desuscribir-id="${id}"]`);
            if (eventoElement) {
                eventoElement.closest('.list-group-item').remove();
            }
        } else {
            console.log('Ocurrió un error al desuscribirse del evento');
        }
    } catch (error) {
        console.error('Error:', error);
        console.log('Ocurrió un error al desuscribirse del evento');
    }
}
