/*function inicio(){
    let form = document.getElementById('eliminarInscriptoForm');
    form.addEventListener('submit', enviarFormEliminar);
}

function enviarFormEliminar(e){
    e.preventDefault();// valida que no haya errores antes de enviar el form
    console.log('no hubo recarga de pagina');
}

window.onload = inicio;*/

document.addEventListener('DOMContentLoaded', function() {

const unsubscribeButtons = document.querySelectorAll('button[data-desuscribir-id]');

    unsubscribeButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const id_usuario = this.getAttribute('data-desuscribir-id')           
            const id_evento = this.getAttribute('data-desuscribir-evento-id')  
            await eliminarSuscripcion(id_usuario, id_evento); // Esperamos que la función async se complete
        });
    });
});

async function eliminarSuscripcion(id_usuario, id_evento) {
    try {
        const response = await fetch(`/TP-Programacion-WEB/controllers/AdministradorController.php?borrarInscripto=`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                id_usuario : id_usuario,
                id_evento :id_evento
            })
        });

        const data = await response.json(); // Esperamos la respuesta
        console.log(data);
        

        if (data.body) {
            console.log('Has desuscripto al alumno del evento con éxito');
            // Eliminar el evento solo de la lista de suscripciones
            const eventoElement = document.querySelector(`[data-desuscribir-id="${id_usuario}"]`);
            if (eventoElement) {
                eventoElement.closest('.list-group-item').remove();
            }

            
        } else {
            
            console.log('Ocurrió un error al desuscribir al lalumno del evento');
        }
    } catch (error) {
        console.error('Error:', error);
        console.log('Ocurrió un error al desuscribir al lalumno del evento');
    }
}

