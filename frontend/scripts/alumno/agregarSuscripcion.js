document.addEventListener('DOMContentLoaded', function() {
    // Captura todos los botones de desuscribirse del evento
    const subscribeButtons = document.querySelectorAll('button[data-suscribir-id]', 'button[data-suscribir-usuario]');
    

    subscribeButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const idUsuario = this.getAttribute('data-suscribir-usuario');        
            const id = this.getAttribute('data-suscribir-id');  
            
            await agregarSuscripcion(idUsuario, id); 
         
        });
    });
});

async function agregarSuscripcion(idUsuario, id) {
    try {
        const response = await fetch(`/TP-Programacion-WEB/controllers/AlumnoController.php?agregarSuscripcion=`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                idUsuario: idUsuario,
                id: id
            })
        });

        const data = await response.json(); 

        if (data.success) {
            console.log('Te has suscrito al evento con éxito');
            
            // Elimina el evento suscrito de la lista de eventos no suscritos
            const eventoElement = document.querySelector(`[data-suscribir-id="${id}"]`);
            if (eventoElement) {
                eventoElement.closest('.list-group-item').remove();
            }
        } else {
            console.log('Ocurrió un error al suscribirse al evento');
        }
    } catch (error) {
        console.error('Error:', error);
        console.log('Ocurrió un error al suscribirse al evento');
    }
}