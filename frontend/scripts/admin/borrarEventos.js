document.addEventListener('DOMContentLoaded', function() {
    // Captura todos los botones de eliminar evento
    const deleteButtons = document.querySelectorAll('button[data-borrar-id]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const id = this.getAttribute('data-borrar-id');
            const nombreEvento = this.getAttribute('data-borrar-nombre');            
            await borrarEvento(id, nombreEvento); // Esperamos que la función async se complete
        });
    });
});

async function borrarEvento(id, nombreEvento) {
    try {
        const response = await fetch(`/TP-Programacion-WEB/controllers/AdministradorController.php?borrarEvento=`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id, nombreEvento: nombreEvento }) // Añadimos la acción
        });

        const data = await response.json(); // Esperamos la respuesta

        if (data.success) {
            console.log('Evento eliminado con éxito');
            document.querySelector(`[data-evento-id="${id}"]`).closest('.list-group-item').remove();
        } else {
            console.log('Ocurrió un error al eliminar el evento');
        }
    } catch (error) {
        console.error('Error:', error);
        console.log('Ocurrió un error al eliminar el evento');
    }
}
